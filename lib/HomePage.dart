import 'package:flutter/material.dart';
import 'package:hospitalfront/Hospital.dart';
import 'package:hospitalfront/RdvPage.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Hospital App',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: const HomePage(),
    );
  }
}

class HomePage extends StatelessWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Hospital App'),
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Bienvenue à l\'hôpital',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 20),
            Expanded(
              child: GridView.count(
                crossAxisCount: 2,
                crossAxisSpacing: 10,
                mainAxisSpacing: 10,
                children: [
                  _buildFeatureTile(
                    context,
                    icon: Icons.calendar_today,
                    title: 'Prendre un rendez-vous',
                    onTap: () {
                      Navigator.push(context,
                      MaterialPageRoute(
                        builder: (context)=>const RdvPage()));
                    },
                  ),
                  _buildFeatureTile(
                    context,
                    icon: Icons.account_circle,
                    title: 'Gerer mon compte',
                    onTap: () {
                      // Naviguer vers la page des médecins
                    },
                  ),
                  _buildFeatureTile(
                    context,
                    icon: Icons.local_hospital,
                    title: 'Services',
                    onTap: () {
                      // Naviguer vers la page des services
                    },
                  ),
                  _buildFeatureTile(
                    context,
                    icon: Icons.info,
                    title: 'À propos de nous',
                    onTap: () {
                      // Naviguer vers la page À propos de nous
                    },
                  ),
                  _buildFeatureTile(
                    context,
                    icon: Icons.search,
                    title: 'Consultez les Hopitaux aux environs',
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => const Hospital(),
                        ),
                      );
                    },
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildFeatureTile(BuildContext context,
      {required IconData icon,
      required String title,
      required VoidCallback onTap}) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        decoration: BoxDecoration(
          color: Colors.blueAccent,
          borderRadius: BorderRadius.circular(10),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(icon, size: 40, color: Colors.white),
            const SizedBox(height: 10),
            Text(
              title,
              textAlign: TextAlign.center,
              style: const TextStyle(color: Colors.white, fontSize: 16),
            ),
          ],
        ),
      ),
    );
  }
}
