package model;

import java.util.ArrayList;

public class ADHERENT {

	private String num;
	private String nom;
	private String prenom;
	private String email;
	
	public ADHERENT(String num, String nom, String prenom, String email, ArrayList<LIVRE> arraylistclient) {
		super();
		this.num = num;
		this.nom = nom;
		this.prenom = prenom;
		this.email = email;
		Arraylistclient = arraylistclient;
	}

	private ArrayList<LIVRE>Arraylistclient = new ArrayList<LIVRE>();


	public String getNum() {
		return num;
	}

	public ADHERENT(ArrayList<LIVRE> arraylistclient) {
		super();
		Arraylistclient = arraylistclient;
	}

	public ArrayList<LIVRE> getArraylistclient() {
		return Arraylistclient;
	}

	public void setArraylistclient(ArrayList<LIVRE> arraylistclient) {
		Arraylistclient = arraylistclient;
	}

	public void setNum(String num) {
		this.num = num;
	}

	public String getNom() {
		return nom;
	}

	public void setNom(String nom) {
		this.nom = nom;
	}

	public String getPrenom() {
		return prenom;
	}

	public void setPrenom(String prenom) {
		this.prenom = prenom;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	@Override
	public String toString() {
		return "ADHERENT []";
	}

}

