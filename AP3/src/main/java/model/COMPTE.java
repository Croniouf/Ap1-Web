package model;



abstract public class COMPTE {
	protected long numero;
	protected float solde;
	protected String devise;
	
	
	private CLIENT titulaire;

	public void debiter(float montant)
	{
		solde=solde-montant;
	}
	
	public void crediter(float montant)
	{
		solde=solde+montant;
	}
	public void Decrire()
	{
		System.out.println("n° : " + numero + "- solde : " + solde + " " + devise);
	}

	public long getNumero() {
		return numero;
	}

	public void setNumero(long numero) {
		this.numero = numero;
	}

	public float getSolde() {
		return solde;
	}

	public void setSolde(float solde) {
		this.solde = solde;
	}

	public String getDevise() {
		return devise;
	}

	public void setDevise(String devise) {
		this.devise = devise;
	}

	public CLIENT getTitulaire() {
		return titulaire;
	}

	public void setTitulaire(CLIENT titulaire) {
		this.titulaire = titulaire;
	}

	public COMPTE(long numero, float solde, String devise, CLIENT titulaire) {
		super();
		this.numero = numero;
		this.solde = solde;
		this.devise = devise;
		this.titulaire = titulaire;
	}
	
	
	

	
	
	

}
