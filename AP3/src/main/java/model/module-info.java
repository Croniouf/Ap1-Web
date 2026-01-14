module Xavier.AP3 {
    requires javafx.controls;
    requires javafx.fxml;
    requires java.sql;
    opens Xavier.AP3 to javafx.fxml;
    exports Xavier.AP3;
}
