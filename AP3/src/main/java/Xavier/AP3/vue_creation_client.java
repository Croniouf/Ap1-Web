package Xavier.AP3;

import java.io.IOException;

import javafx.fxml.FXML;
import javafx.scene.control.Button;

public class vue_creation_client {
	
	@FXML
	
	private Button creation_client_btn;
	
	@FXML
	
	private void Submit_creationClient() throws IOException {
		App.setRoot("vue_creation_client");
	}

}
