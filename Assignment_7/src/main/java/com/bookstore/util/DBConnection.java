package com.bookstore.util;

import java.sql.Connection;
import java.sql.DriverManager;

public class DBConnection {

private static final String URL = "jdbc:mysql://127.0.0.1:3307/ebookshop?useSSL=false&serverTimezone=UTC";    private static final String USERNAME = "root";
    private static final String PASSWORD = "";

    static {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            throw new RuntimeException("MySQL JDBC Driver not found.", e);
        }
    }

    public static Connection getConnection() {
        try {
            return DriverManager.getConnection(URL, USERNAME, PASSWORD);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}