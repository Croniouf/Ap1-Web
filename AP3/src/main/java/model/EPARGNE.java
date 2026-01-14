package model;


public class EPARGNE extends COMPTE {
	private float interet;

	public EPARGNE(long numero, float solde, String devise, CLIENT titulaire, float interet) {
		super(numero, solde, devise, titulaire);
		this.interet = interet;
	}
	
	public void Decrire()
	{
		super.Decrire();
		System.out.println(" taux = "+(interet*100)+"%");
	}
	
	public void ajouter_interet()
	{
		super.solde=super.solde+super.solde*interet;
	}

	


}
