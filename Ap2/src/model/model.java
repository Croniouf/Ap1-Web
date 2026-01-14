package model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

public class model {

    private ArrayList<LIVRE> ListLivre;
    private ArrayList<AUTEUR> ListAuteur;
    private ArrayList<ADHERENT> ListAdherent;
    private Connection con;

    public ArrayList<LIVRE> getListLivre() {
        return ListLivre;
    }

    public ArrayList<AUTEUR> getListAuteur() {
        return ListAuteur;
    }

    public ArrayList<ADHERENT> getListAdherent() {
        return ListAdherent;
    }

    public void setListLivre(ArrayList<LIVRE> listLivre) {
        ListLivre = listLivre;
    }

    public void setListAuteur(ArrayList<AUTEUR> listAuteur) {
        ListAuteur = listAuteur;
    }

    public void setListAdherent(ArrayList<ADHERENT> listAdherent) {
        ListAdherent = listAdherent;
    }

    public void getAll() throws SQLException {
        ListAdherent.clear();
        ListAuteur.clear();
        ListLivre.clear();

        Statement stmt = con.createStatement();
        
        //*************************************************************************************
        // CHARGER LES AUTEURS
        //*************************************************************************************
        ResultSet resultat = stmt.executeQuery("SELECT * FROM AUTEUR");
        while (resultat.next()) {
            AUTEUR a = new AUTEUR(
                resultat.getString("num"),
                resultat.getString("nom"),
                resultat.getString("prenom"),
                resultat.getString("date_naissance"),
                resultat.getString("description")
            );
            ListAuteur.add(a);
        }

         //*************************************************************************************
         // CHARGER LES ADHERENTS
         //*************************************************************************************
        resultat = stmt.executeQuery("SELECT * FROM ADHERENT");
        while (resultat.next()) {
            ADHERENT ad = new ADHERENT(
                resultat.getString("num"),
                resultat.getString("nom"),
                resultat.getString("prenom"),
                resultat.getString("email"),
                new ArrayList<LIVRE>()
            );
            ListAdherent.add(ad);
        }

        //*************************************************************************************
        // CHARGER LES LIVRES
        //*************************************************************************************
        resultat = stmt.executeQuery("SELECT * FROM LIVRE");
        while (resultat.next()) {
            AUTEUR a = null;
            ADHERENT ad = null;

            // RECHERCHE DE L'AUTEUR
            String numauteur = resultat.getString("auteur");
            if (numauteur != null) {
                a = findAuteur(numauteur);
            }

            // RECHERCHE DE L'ADHERENT
            String numadherent = resultat.getString("adherent");
            if (numadherent != null) {
                ad = findAdherent(numadherent);
            }

            // CREATION DU LIVRE
            LIVRE l = new LIVRE(
                resultat.getString("ISBN"),
                resultat.getString("titre"),
                resultat.getFloat("prix"),
                a,
                ad
            );
            ListLivre.add(l);

            // AJOUT DU LIVRE A L'ADHERENT      
            if (ad != null) {
                //ad.getListLivre().add(l);
            }
        }
    }

    public AUTEUR findAuteur(String num) {
        for (AUTEUR auteur : ListAuteur) {
            if (num.equals(auteur.getNum())) {
                return auteur;
            }
        }
        return null;
    }

    public ADHERENT findAdherent(String num) {
        for (ADHERENT ad : ListAdherent) {
            if (num.equals(ad.getNum())) {
                return ad;
            }
        }
        return null;
    }

    public LIVRE findLivre(String num) {
        for (LIVRE livre : ListLivre) {
            if (num.equals(livre.getISBN())) {
                return livre;
            }
        }
        return null;
    }

    public model() throws ClassNotFoundException, SQLException {
        ListLivre = new ArrayList<>();
        ListAuteur = new ArrayList<>();
        ListAdherent = new ArrayList<>();

        String BDD = "ap2_bdd";
        String url = "jdbc:mysql://localhost:3306/" + BDD 
                     + "?useUnicode=true&characterEncoding=UTF-8";
        String user = "root";
        String passwrd = "root";

        // Driver MySQL ANCIEN (5.0.5)
        Class.forName("com.mysql.jdbc.Driver");

        this.con = DriverManager.getConnection(url, user, passwrd);
        System.out.println("Connection OK");
    }
    
    public boolean modifprofil(String nom, String prenom, String email, String num) throws SQLException {
    	String requete="UPDATE adherent SET nom=?,prenom=?,email=? WHERE num=  ?;";
    	PreparedStatement pstmt=con.prepareStatement(requete);
    	pstmt.setString(1, nom);
    	pstmt.setString(2, prenom);
    	pstmt.setString(3, email);
    	pstmt.setString(4, num);
    	int verif=pstmt.executeUpdate();
    	if(verif==1) {
    		return true;	
    	}
    	else {
    		return false;
    	}
    }

}

