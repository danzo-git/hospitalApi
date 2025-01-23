<?php 
namespace App\Service;

use App\Entity\Doctor;
use App\Repository\RdvRepository;

class DisponibiliteGenerator
{
    public function __construct(private RdvRepository $rdvRepository) {}

    public function generateSlots(Doctor $doctor, \DateTimeInterface $date, int $dureeMinutes = 30): array
    {
        $slots = [];
        $jourSemaine = (int) $date->format('N'); // Lundi = 1, Dimanche = 7

        // Vérifier si le médecin travaille ce jour
        if (!in_array($jourSemaine, $doctor->getJoursTravailles())) {
            return $slots; // Pas de créneaux pour ce jour
        }

        // Générer les créneaux du matin
        $slots = array_merge($slots, $this->generateDaySlots(
            $date,
            $doctor->getHeureDebutMatin(),
            $doctor->getHeureFinMatin(),
            $dureeMinutes,
            $doctor
        ));

        // Générer les créneaux de l'après-midi
        if ($doctor->getHeureDebutApresMidi() && $doctor->getHeureFinApresMidi()) {
            $slots = array_merge($slots, $this->generateDaySlots(
                $date,
                $doctor->getHeureDebutApresMidi(),
                $doctor->getHeureFinApresMidi(),
                $dureeMinutes,
                $doctor
            ));
        }

        return $slots;
    }

    private function generateDaySlots(
        \DateTimeInterface $date,
        \DateTimeInterface $heureDebut,
        \DateTimeInterface $heureFin,
        int $dureeMinutes,
        doctor $doctor
    ): array {
        $slots = [];
        $current = new \DateTime($date->format('Y-m-d') . ' ' . $heureDebut->format('H:i'));

        while ($current < new \DateTime($date->format('Y-m-d') . ' ' . $heureFin->format('H:i'))) {
            $slotEnd = (clone $current)->modify("+$dureeMinutes minutes");

            // Vérifier si le créneau est déjà réservé
            if (!$this->rdvRepository->isSlotReserved($doctor, $current, $slotEnd)) {
                $slots[] = [
                    'date' => $date->format('Y-m-d'),
                    'heure_debut' => $current->format('H:i'),
                    'heure_fin' => $slotEnd->format('H:i'),
                ];
            }

            $current = $slotEnd;
        }

        return $slots;
    }
}
