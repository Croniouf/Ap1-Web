package model;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class CLIENTDAO {
	public CLIENT findByEmail(String email) throws SQLException, ClassNotFoundException {
		Connection conn = ConnectionFactory.get();
		Statement stmt = conn.createStatement();
		ResultSet resultat=stmt.executeQuery("SELECT* from CLIENT");
		CLIENT c=null;
		while(resultat.next()) {
			c = new CLIENT (resultat.getString(2), resultat.getString(3), 0, null, null, null, null, null, null);
		}
		return c;
		
	}
}
