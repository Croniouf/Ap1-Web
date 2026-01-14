package model;


import java.util.ArrayList;
import java.util.Date;

public class CLIENT {
	private String nom;
	private String prenom;
	private int genre;
	private Date dateN;
	private String adresse;
	private String categ;
	private String tel;
	private String email;
	private ArrayList<COMPTE> lstcompte;
	
	public void info_compte()
	{
		String var;
		if (genre==1)
			var="M. ";
		else
			var="Mme ";
		System.out.println("Liste des comptes de "+var+nom+" "+ prenom);
		for (int i=0;i<lstcompte.size();i++)
		{
			lstcompte.get(i).Decrire();
		}
	}
	
	public CLIENT(String nom, String prenom, int genre, Date dateN, String adresse, String categ, String tel,
			String email, ArrayList<COMPTE> lstcompte) {
		super();
		this.nom = nom;
		this.prenom = prenom;
		this.genre = genre;
		this.dateN = dateN;
		this.adresse = adresse;
		this.categ = categ;
		this.tel = tel;
		this.email = email;
		this.lstcompte = lstcompte;
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
	public int getGenre() {
		return genre;
	}
	public void setGenre(int genre) {
		this.genre = genre;
	}
	public Date getDateN() {
		return dateN;
	}
	public void setDateN(Date dateN) {
		this.dateN = dateN;
	}
	public String getAdresse() {
		return adresse;
	}
	public void setAdresse(String adresse) {
		this.adresse = adresse;
	}
	public String getCateg() {
		return categ;
	}
	public void setCateg(String categ) {
		this.categ = categ;
	}
	public String getTel() {
		return tel;
	}
	public void setTel(String tel) {
		this.tel = tel;
	}
	public String getEmail() {
		return email;
	}
	public void setEmail(String email) {
		this.email = email;
	}
	public ArrayList<COMPTE> getLstcompte() {
		return lstcompte;
	}
	public void setLstcompte(ArrayList<COMPTE> lstcompte) {
		this.lstcompte = lstcompte;
	}

	public void info_compte1() {
		// TODO Auto-generated method stub
		
	}
	
	
	
}
