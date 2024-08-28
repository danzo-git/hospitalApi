import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:hospitalfront/Hospital.dart';
import 'package:hospitalfront/Menu.dart';
import 'package:hospitalfront/RdvPage.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

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

Future<Map<String, dynamic>> getUserInfo() async {
  final prefs = await SharedPreferences.getInstance();
  final String? token = prefs.getString('token');
  
  if (token == null) {
    throw Exception('No token found');
  }

  final response = await http.get(
    Uri.parse('http://10.0.2.2:8000/api/patients/{id}'),
    headers: {
      'Authorization': 'Bearer $token',
    },
  );

  if (response.statusCode == 200) {
    print(token);
    return json.decode(response.body);
  } else {
    // Gérer l'erreur de récupération des informations de l'utilisateur
    throw Exception('Failed to load user info');
  }
}

class HomePage extends StatefulWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  late Future<Map<String, dynamic>> userInfo;

  @override
  void initState() {
    super.initState();
    userInfo = getUserInfo();
    print(userInfo);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: FutureBuilder<Map<String, dynamic>>(
          future: userInfo,
          
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Text('Bienvenue');
            } else if (snapshot.hasError) {
              return const Text('Bienvenue');
            } else if (snapshot.hasData) {
              final name = snapshot.data?['name'] ?? 'User';
              return Text('Bienvenue $name', style: const TextStyle(color: Colors.black),);
            } else {
              return const Text('Bienvenue');
            }
          },
        ),
      ),
      drawer: Drawer(
        child: menu(),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
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
                          builder: (context) => const RdvPage(),
                        ),
                      );
                    },
                  ),
                  _buildFeatureTile(
                    context,
                    icon: Icons.account_circle,
                    title: 'Gérer mon compte',
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
                    title: 'Consultez les Hôpitaux aux environs',
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
