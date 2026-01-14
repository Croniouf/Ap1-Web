package view;

import java.awt.EventQueue;


import javax.swing.JFrame;
import javax.swing.JLabel;
import java.awt.BorderLayout;
import javax.swing.JTextField;

import controller.mainMVC;
import model.ADHERENT;

import javax.swing.JButton;
import javax.swing.JPanel;
import javax.swing.JList;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.awt.event.ActionEvent;

public class View_Profil {

	private JFrame frame;
	private JTextField textField_numclient;
	private JTextField textField_nom;
	private JTextField textField_prenom;
	private JTextField textField_email;
	private String num;

	

	/**
	 * Create the application.
	 * @throws SQLException 
	 */
	public View_Profil() throws SQLException {
		mainMVC.getM().getAll();
		initialize();
		frame.setVisible(true);
	}

	/**
	 * Initialize the contents of the frame.
	 */
	private void initialize() {
		frame = new JFrame();
		frame.setBounds(100, 100, 923, 482);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.getContentPane().setLayout(null);
		
		JLabel lblNewLabel_numclient = new JLabel("N° Client : ");
		lblNewLabel_numclient.setBounds(299, 27, 72, 14);
		frame.getContentPane().add(lblNewLabel_numclient);
		
		textField_numclient = new JTextField();
		textField_numclient.setBounds(381, 24, 134, 20);
		frame.getContentPane().add(textField_numclient);
		textField_numclient.setColumns(10);
		
		
		
		JPanel panel = new JPanel();
		panel.setBounds(171, 89, 589, 325);
		frame.getContentPane().add(panel);
		panel.setLayout(null);
		panel.setVisible(false);
		
		textField_nom = new JTextField();
		textField_nom.setColumns(10);
		textField_nom.setBounds(98, 136, 134, 20);
		panel.add(textField_nom);
		
		textField_prenom = new JTextField();
		textField_prenom.setColumns(10);
		textField_prenom.setBounds(98, 167, 134, 20);
		panel.add(textField_prenom);
		
		textField_email = new JTextField();
		textField_email.setColumns(10);
		textField_email.setBounds(98, 198, 134, 20);
		panel.add(textField_email);
		
		JLabel lblNewLabel_nom = new JLabel("Nom :");
		lblNewLabel_nom.setBounds(35, 139, 57, 14);
		panel.add(lblNewLabel_nom);
	
		
		JLabel lblNewLabel_prenom = new JLabel("Prenom :");
		lblNewLabel_prenom.setBounds(27, 170, 65, 14);
		panel.add(lblNewLabel_prenom);
		
		JLabel lblNewLabel_email = new JLabel("Email :");
		lblNewLabel_email.setBounds(35, 201, 53, 14);
		panel.add(lblNewLabel_email);
		
		JButton btnNewButton_maj = new JButton("Maj");
		btnNewButton_maj.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				
				
				String email = textField_email.getText();
				String nom = textField_nom.getText();
				String prenom = textField_prenom.getText();
			    try {
					boolean verif=mainMVC.getM().modifprofil(nom, prenom, email, num);
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
		});
		btnNewButton_maj.setBounds(105, 246, 89, 23);
		panel.add(btnNewButton_maj);
		
		JList list_ISBN = new JList();
		list_ISBN.setBounds(367, 65, 198, 216);
		panel.add(list_ISBN);
		
		
		JButton btnNewButton_numclient = new JButton("OK");
		btnNewButton_numclient.addActionListener(new ActionListener() {
		    public void actionPerformed(ActionEvent e) {
		        num = textField_numclient.getText();
		        ADHERENT ad = mainMVC.getM().findAdherent(num);
		        if (ad==null) {
		        	panel.setVisible(false); 
		            System.out.println("Aucun adherent trouvé !");
		        } else {
		            panel.setVisible(true);
		            textField_nom.setText(ad.getNom());
		            textField_prenom.setText(ad.getPrenom());
		            textField_email.setText(ad.getEmail());
		        }
		    }
		});

		btnNewButton_numclient.setBounds(404, 55, 89, 23);
		frame.getContentPane().add(btnNewButton_numclient);
	}}

