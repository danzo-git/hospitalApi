class PatientData {
  String? name;
  String? firstName;
  String? email;
  String? number;
  int? age;
  String? allergy;
  String? potentialIllness;
  String? file;
  
  String? password;

  PatientData(
      {required this.name,
      required this.firstName,
      required this.email,
      required this.number,
      required this.age,
      required this.allergy,
      required this.potentialIllness,
      required this.file, 
      required this.password});

  factory PatientData.fromJson(Map<String, dynamic> json) {
    return PatientData(
      name: json['name'],
      firstName: json['firstName'],
      email: json['email'],
      number: json['number'],
      age: json['age'],
      allergy: json['allergy'],
      potentialIllness: json['potentialIllness'],
      file: json['file'], 
      password: json['password'],
    );
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['name'] = this.name;
    data['firstName'] = this.firstName;
    data['email'] = this.email;
    data['number'] = this.number;
    data['age'] = this.age;
    data['allergy'] = this.allergy;
    data['potentialIllness'] = this.potentialIllness;
    data['file'] = this.file;
    data['password'] = this.password;
    return data;
  }
}
