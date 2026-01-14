package controller;

import java.sql.SQLException;

import model.model;
import view.View_Accueil;
import model.LIVRE;

public class mainMVC {

    private static model m;

    public static model getM() {
        return m;
    }

    public static void main(String[] args) throws ClassNotFoundException, SQLException {
        
    	System.out.println("main MVC");
        m = new model();
        View_Accueil window = new View_Accueil();

        
    }
}
