package model;

public class LIVRE {
	private String ISBN;
	private String titre;
	private float prix;
	private ADHERENT Emprunteur;
	
	public LIVRE(String iSBN, String titre, float f, AUTEUR a, ADHERENT ad) {
		super();
		ISBN = iSBN;
		this.titre = titre;
		this.prix = f;
		Emprunteur = ad;
		Auteur = a;
	}

	public ADHERENT getEmprunteur() {
		return Emprunteur;
	}

	public void setEmprunteur(ADHERENT emprunteur) {
		Emprunteur = emprunteur;
	}

	public AUTEUR getAuteur() {
		return Auteur;
	}

	public void setAuteur(AUTEUR auteur) {
		Auteur = auteur;
	}

	private AUTEUR Auteur;

	public String getISBN() {
		return ISBN;
	}

	public void setISBN(String iSBN) {
		ISBN = iSBN;
	}

	public String getTitre() {
		return titre;
	}

	public void setTitre(String titre) {
		this.titre = titre;
	}

	public float getPrix() {
		return prix;
	}

	public void setPrix(int prix) {
		this.prix = prix;
	}

	

}

