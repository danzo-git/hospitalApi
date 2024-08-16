import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'HospitalData.dart';

class Hospital extends StatefulWidget {
  const Hospital({Key? key}) : super(key: key);

  @override
  State<Hospital> createState() => _HospitalState();
}

class _HospitalState extends State<Hospital> {
  late Future<List<HospitalData>> futureData;

  @override
  void initState() {
    super.initState();
    futureData = fetchData();  // Ensure futureData is initialized correctly
  }

  Future<List<HospitalData>> fetchData() async {
    final response = await http.get(Uri.parse('http://10.0.2.2:8000/api/hospitals'));

    if (response.statusCode == 200) {
      // If the server did return a 200 OK response, then parse the JSON.
      print(response.body[2]);
      var body = jsonDecode(response.body);

      if (body == null || body['hydra:member'] == null) {
        throw Exception('No data found');
      }

      List<HospitalData> hospitals = List.empty(growable: true);
      for (var item in body['hydra:member']) {
        hospitals.add(HospitalData.fromJson(item));
      }
      return hospitals;
    } else {
      // If the server did not return a 200 OK response, then throw an exception.
      print("Error: ${response.body}");
      throw Exception('Failed to load hospital data');
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        appBar: AppBar(
          title: const Text("Hospital Front"),
          centerTitle: true,
        ),
        body: FutureBuilder<List<HospitalData>>(
          future: futureData,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(child: Text('Error: ${snapshot.error}'));
            } else if (snapshot.hasData) {
              return ListView.builder(
                itemCount: snapshot.data!.length,
                itemBuilder: (BuildContext context, int index) {
                  return ListTile(
                    title: Text('${snapshot.data![index].name}'),
                  );
                },
              );
            } else {
              return const Center(child: Text('No data available'));
            }
          },
        ),
      ),
    );
  }
}
