package Xavier.AP3;

import java.io.IOException;
import javafx.fxml.FXML;

public class PrimaryController {

    @FXML
    private void switchTovue() throws IOException {
        App.setRoot("vue");
    }
}
