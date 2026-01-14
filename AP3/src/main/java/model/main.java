package model;

import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;

public class main {

public static void main(String[] args) throws ParseException, ClassNotFoundException, SQLException {

// TODO Auto-generated method stub

CLIENT c = new CLIENT("Gravouil", "Benjamin", 1,new SimpleDateFormat("dd/MM/yyyy").parse("02/05/1977"), "lycee paul Lapie 92400 COURBEVOIE", "enseignant", "0612545475", "prof.gravouil@gmail.com", new ArrayList<COMPTE>());


c.getLstcompte().add(new COURANT(13245411324L, 2548200, "€",c,0,0));

c.getLstcompte().add(new EPARGNE(32544771289L, 1000, "€", c,(float) 0.05));

c.getLstcompte().add(new COURANT(22544771289L,-214,"€",c, 0, 0));

((EPARGNE) c.getLstcompte().get(1)).ajouter_interet();

c.info_compte();

CLIENTDAO cDAO = new CLIENTDAO();
CLIENT client = cDAO.findByEmail("prof.gravouil@gmail.com");
if (client != null) {
System.out.println(client.getNom());
}
else {
System.out.println("Client introuvable");
}
}
} 