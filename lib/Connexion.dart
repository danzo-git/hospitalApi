import 'package:flutter/material.dart';
class Connexion  extends StatefulWidget{

@override
  State<Connexion> createState() => _ConnexionState();
}

class _ConnexionState extends State<Connexion> {
  @override
    final _formKey = GlobalKey<FormState>();
     String? _email;
      String? _password;

      void _submitForm() {
    if (_formKey.currentState!.validate()) {
      _formKey.currentState!.save();
      // Traite les données du formulaire ici, par exemple en envoyant à un serveur ou en enregistrant localement
     
      print("Email: $_email");
    
      print("Mot de passe: $_password");
    }
  }
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Connexion"),
      ),
      body: Padding(padding: const EdgeInsets.all(16.0),
      child: Form(
        key: _formKey,
        child: Column(
          children:<Widget> [
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
              const SizedBox(height: 16.0),
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
               ElevatedButton(
                onPressed: _submitForm,
                child: const Text('Soumettre'),
              ),
        ]
        )
      )
      ),
    );
  }
}