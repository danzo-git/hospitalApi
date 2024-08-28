import 'package:flutter/material.dart';
import 'package:hospitalfront/Menu.dart';

class RdvPage extends StatefulWidget {
  const RdvPage({super.key});

  @override
  State<RdvPage> createState() => _RdvPageState();
}

class _RdvPageState extends State<RdvPage> {
  @override
  Widget build(BuildContext context) {
  

    Widget TextForm() {
      return ListView.builder(
          itemCount: 1,
          itemBuilder: (context, index) {
            return  Column(
              children: [
                const SizedBox(height: 10),
                TextFormField(
                     textCapitalization: TextCapitalization.words,
            decoration: const InputDecoration(
              border: UnderlineInputBorder(),
              filled: true,
              icon: Icon(Icons.person),
              hintText: 'What do people call you?',
              labelText: 'Service a consulter *',
                )
              ),
               const SizedBox(height: 10),
                 TextFormField(
                     textCapitalization: TextCapitalization.words,
            decoration: const InputDecoration(
              border: UnderlineInputBorder(),
              filled: true,
              icon: Icon(Icons.person),
              hintText: 'Quelles hopitals souhaitez vous?',
              labelText: 'Hopital a consulter *',
                )
              ),
               TextFormField(
                     textCapitalization: TextCapitalization.words,
            decoration: const InputDecoration(
              border: UnderlineInputBorder(),
              filled: true,
              icon: Icon(Icons.person),
              hintText: 'numero de Telephone?',
              labelText: 'Telephone *',
                )
              ),
              ],
            );
          });
    }

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Color.fromARGB(255, 9, 6, 235),
        title: const Text(
          'Prendre un rendez-vous',
          style: TextStyle(color: Colors.white),
        ),
      ),
      body:  Center(
        child: TextForm(),
      ),
      drawer: Drawer(
        child: menu(),
      ),
    );
  }
}

class _NewPage extends MaterialPageRoute<void> {
  _NewPage(int id)
      : super(
          builder: (BuildContext context) {
            return Scaffold(
              appBar: AppBar(
                title: Text('Page $id'),
                elevation: 1.0,
              ),
              body: Center(
                child: Text('Page $id'),
              ),
            );
          },
        );
}
