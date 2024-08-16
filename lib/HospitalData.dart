class HospitalData {
  String? name;
  String? position;

  HospitalData({this.name, this.position});

  factory HospitalData.fromJson(Map<String, dynamic> json) {
    return HospitalData(
      name: json['name'],
      position: json['position'],
    );
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['name'] = name;
    data['position'] = position;
    return data;
  }
}