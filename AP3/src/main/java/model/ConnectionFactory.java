package model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionFactory {
	private static final String BDD="2025_ap3_banque";
	private static final String URL= "jdbc:mysql://localhost:3306/"+BDD;
	private static final String USER = "root";
	private static final String PASS = "";
	
	public static Connection get() throws ClassNotFoundException, SQLException {
	Class.forName("com.mysql.jdbc.Driver");
	return DriverManager.getConnection(URL, USER, PASS);
	}
}
