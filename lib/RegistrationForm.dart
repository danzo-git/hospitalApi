import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:file_picker/file_picker.dart';
import 'package:hospitalfront/Connexion.dart';
import 'package:hospitalfront/PatientData.dart';
import 'package:http/http.dart' as http;

class RegistrationForm extends StatefulWidget {
  const RegistrationForm({super.key});

  @override
  _RegistrationFormState createState() => _RegistrationFormState();
}

class _RegistrationFormState extends State<RegistrationForm> {
  final _formKey = GlobalKey<FormState>();

  String? _name;
  String? _firstName;
  String? _email;
  String? _number;
  int? _age;
  String? _allergy;
  String? _potentialIllness;
  String? _selectedFile;
  String? _password;
  List? _roles;

  
  

  Future<http.Response> createPatient(PatientData patient) async {
    final response = await http.post(
      Uri.parse('http://10.0.2.2:8000/api/patients'),
      headers: <String, String>{
        'Content-Type': 'application/ld+json',
      },
      body: jsonEncode(patient.toJson()),
    );

    if (response.statusCode == 201) {
      // Si la requête a réussi et les données ont été insérées
      return response;
    } else {
      // Si la requête a échoué
      throw Exception('Échec de la création de l\'hôpital');
    }
  }

  Future<void> _pickFile() async {
    FilePickerResult? result = await FilePicker.platform.pickFiles();

    if (result != null) {
      setState(() {
        _selectedFile = result.files.single.name;
      });
    }
  }

  void _submitForm() {
    if (_formKey.currentState!.validate()) {
      _formKey.currentState!.save();

      // Crée un objet PatientData avec les données du formulaire
      PatientData newPatient = PatientData(
        name: _name!,
        firstName: _firstName!,
        email: _email!,
        number: _number!,
        age: _age!,
        allergy: _allergy,
        potentialIllness: _potentialIllness,
        file: _selectedFile,
        password: _password!,
        roles: ["ROLE_USER"],  // Initialisation du rôle par défaut
      );

      // Appelle la fonction createPatient pour envoyer les données à l'API
      createPatient(newPatient).then((response) {
        // ignore: use_build_context_synchronously
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Inscription réussie!')),
        );
      }).catchError((error) {
        // ignore: use_build_context_synchronously
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Échec de l\'inscription: $error')),
        );
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Inscription '),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: ListView(
            children: <Widget>[
              TextFormField(
                decoration: const InputDecoration(labelText: 'Nom'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer votre nom';
                  }
                  return null;
                },
                onSaved: (value) => _name = value,
              ),
              TextFormField(
                decoration: const InputDecoration(labelText: 'Prénom'),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer votre prénom';
                  }
                  return null;
                },
                onSaved: (value) => _firstName = value,
              ),
              TextFormField(
                decoration: const InputDecoration(labelText: 'Email'),
                keyboardType: TextInputType.emailAddress,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer votre email';
                  }
                  if (!RegExp(r'^[^@]+@[^@]+\.[^@]+').hasMatch(value)) {
                    return 'Veuillez entrer un email valide';
                  }
                  return null;
                },
                onSaved: (value) => _email = value,
              ),
              TextFormField(
                decoration:
                    const InputDecoration(labelText: 'Numéro de téléphone'),
                keyboardType: TextInputType.phone,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer votre numéro de téléphone';
                  }
                  return null;
                },
                onSaved: (value) => _number = value,
              ),
              TextFormField(
                decoration: const InputDecoration(labelText: 'Âge'),
                keyboardType: TextInputType.number,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer votre âge';
                  }
                  final age = int.tryParse(value);
                  if (age == null || age <= 0) {
                    return 'Veuillez entrer un âge valide';
                  }
                  return null;
                },
                onSaved: (value) => _age = int.tryParse(value!),
              ),
              TextFormField(
                decoration: const InputDecoration(labelText: 'Allergies'),
                onSaved: (value) => _allergy = value,
              ),
              TextFormField(
                decoration:
                    const InputDecoration(labelText: 'Maladies potentielles'),
                onSaved: (value) => _potentialIllness = value,
              ),
              TextFormField(
                decoration: const InputDecoration(labelText: 'Mot de passe'),
                obscureText: true, // Masquer le texte saisi
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Veuillez entrer un mot de passe';
                  }
                  if (value.length < 6) {
                    return 'Le mot de passe doit contenir au moins 6 caractères';
                  }
                  return null;
                },
                onSaved: (value) => _password = value,
              ),
              const SizedBox(height: 20),
              Text(
                _selectedFile == null
                    ? 'Aucun fichier sélectionné'
                    : 'Fichier sélectionné : $_selectedFile',
              ),
              ElevatedButton(
                onPressed: _pickFile,
                child: const Text('Sélectionner un fichier'),
              ),
              const SizedBox(height: 20),
              ElevatedButton(
                onPressed: _submitForm,
                child: const Text('Soumettre'),
              ),
              const SizedBox(height: 100),
              ElevatedButton(
                  onPressed: () => {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => Connexion()))
                      },
                  child: const Text("Connexion")),
            ],
          ),
        ),
      ),
    );
  }
}
