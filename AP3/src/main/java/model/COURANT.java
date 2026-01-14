package model;


public class COURANT extends COMPTE{
	private int numCB;
	private int decouvert;
	public int getNumCB() {
		return numCB;
	}
	public void setNumCB(int numCB) {
		this.numCB = numCB;
	}
	public int getDecouvert() {
		return decouvert;
	}
	public void setDecouvert(int decouvert) {
		this.decouvert = decouvert;
	}
	public COURANT(long numero, float solde, String devise, CLIENT titulaire, int numCB, int decouvert) {
		super(numero, solde, devise, titulaire);
		this.numCB = numCB;
		this.decouvert = decouvert;
	}
	
}
