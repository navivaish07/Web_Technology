package com.bookstore.servlet;

import com.bookstore.util.DBConnection;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class BookServlet extends HttpServlet {

    private static final String SELECT_BOOKS_SQL =
            "SELECT book_id, book_title, book_author, book_price, quantity FROM ebookshop";
    private static final String INSERT_BOOK_SQL =
            "INSERT INTO ebookshop (book_title, book_author, book_price, quantity) VALUES (?, ?, ?, ?)";

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        response.setContentType("text/html;charset=UTF-8");

        try (PrintWriter out = response.getWriter()) {
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Bookstore Inventory</title>");
            out.println("<style>");
            out.println("body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 32px; }");
            out.println(".container { max-width: 900px; margin: auto; background: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); }");
            out.println("h1 { color: #1f2937; margin-top: 0; }");
            out.println("table { width: 100%; border-collapse: collapse; margin-top: 20px; }");
            out.println("th, td { border: 1px solid #d1d5db; padding: 12px; text-align: left; }");
            out.println("th { background-color: #2563eb; color: white; }");
            out.println("tr:nth-child(even) { background-color: #f9fafb; }");
            out.println(".message { padding: 12px; border-radius: 8px; margin-top: 16px; }");
            out.println(".error { background-color: #fee2e2; color: #991b1b; }");
            out.println(".empty { background-color: #e0f2fe; color: #075985; }");
            out.println(".actions { margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap; }");
            out.println("a { display: inline-block; color: #2563eb; text-decoration: none; }");
            out.println("</style>");
            out.println("</head>");
            out.println("<body>");
            out.println("<div class='container'>");
            out.println("<h1>Bookstore Inventory</h1>");

            try (Connection connection = DBConnection.getConnection();
                 PreparedStatement preparedStatement = connection.prepareStatement(SELECT_BOOKS_SQL);
                 ResultSet resultSet = preparedStatement.executeQuery()) {

                boolean hasRecords = false;
                out.println("<table>");
                out.println("<tr><th>ID</th><th>Title</th><th>Author</th><th>Price</th><th>Quantity</th></tr>");

                while (resultSet.next()) {
                    hasRecords = true;
                    out.println("<tr>");
                    out.println("<td>" + resultSet.getInt("book_id") + "</td>");
                    out.println("<td>" + escapeHtml(resultSet.getString("book_title")) + "</td>");
                    out.println("<td>" + escapeHtml(resultSet.getString("book_author")) + "</td>");
                    out.println("<td>" + resultSet.getDouble("book_price") + "</td>");
                    out.println("<td>" + resultSet.getInt("quantity") + "</td>");
                    out.println("</tr>");
                }

                out.println("</table>");

                if (!hasRecords) {
                    out.println("<div class='message empty'>No books found in the ebookshop table.</div>");
                }
            } catch (SQLException e) {
                out.println("<div class='message error'>Database error: " + escapeHtml(e.getMessage()) + "</div>");
            }

            out.println("<div class='actions'>");
            out.println("<a href='index.html'>Back to Home</a>");
            out.println("<a href='add-book.html'>Add New Book</a>");
            out.println("</div>");
            out.println("</div>");
            out.println("</body>");
            out.println("</html>");
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        request.setCharacterEncoding("UTF-8");
        response.setContentType("text/html;charset=UTF-8");

        String title = request.getParameter("book_title");
        String author = request.getParameter("book_author");
        String priceText = request.getParameter("book_price");
        String quantityText = request.getParameter("quantity");

        try (PrintWriter out = response.getWriter()) {
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Add Book Result</title>");
            out.println("<style>");
            out.println("body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 32px; }");
            out.println(".container { max-width: 700px; margin: auto; background: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); }");
            out.println(".message { padding: 14px; border-radius: 8px; margin-top: 16px; }");
            out.println(".success { background-color: #dcfce7; color: #166534; }");
            out.println(".error { background-color: #fee2e2; color: #991b1b; }");
            out.println(".actions { margin-top: 16px; display: flex; gap: 12px; flex-wrap: wrap; }");
            out.println("a { color: #2563eb; text-decoration: none; }");
            out.println("</style>");
            out.println("</head>");
            out.println("<body>");
            out.println("<div class='container'>");
            out.println("<h1>Book Submission</h1>");

            if (isBlank(title) || isBlank(author) || isBlank(priceText) || isBlank(quantityText)) {
                out.println("<div class='message error'>All fields are required.</div>");
                printActionLinks(out);
                out.println("</div></body></html>");
                return;
            }

            try {
                double price = Double.parseDouble(priceText);
                int quantity = Integer.parseInt(quantityText);

                if (price < 0 || quantity < 0) {
                    out.println("<div class='message error'>Price and quantity must be non-negative values.</div>");
                    printActionLinks(out);
                    out.println("</div></body></html>");
                    return;
                }

                try (Connection connection = DBConnection.getConnection();
                     PreparedStatement preparedStatement = connection.prepareStatement(INSERT_BOOK_SQL)) {

                    if (connection == null) {
                        out.println("<div class='message error'>Database connection could not be established.</div>");
                    } else {
                        preparedStatement.setString(1, title);
                        preparedStatement.setString(2, author);
                        preparedStatement.setDouble(3, price);
                        preparedStatement.setInt(4, quantity);

                        int rowsInserted = preparedStatement.executeUpdate();
                        if (rowsInserted > 0) {
                            out.println("<div class='message success'>Book added successfully to the database.</div>");
                        } else {
                            out.println("<div class='message error'>Book could not be added.</div>");
                        }
                    }
                } catch (SQLException e) {
                    out.println("<div class='message error'>Database error: " + escapeHtml(e.getMessage()) + "</div>");
                }
            } catch (NumberFormatException e) {
                out.println("<div class='message error'>Price must be a valid number and quantity must be a valid integer.</div>");
            }

            printActionLinks(out);
            out.println("</div>");
            out.println("</body>");
            out.println("</html>");
        }
    }

    private void printActionLinks(PrintWriter out) {
        out.println("<div class='actions'>");
        out.println("<a href='add-book.html'>Add Another Book</a>");
        out.println("<a href='books'>View Books</a>");
        out.println("<a href='index.html'>Back to Home</a>");
        out.println("</div>");
    }

    private boolean isBlank(String value) {
        return value == null || value.trim().isEmpty();
    }

    private String escapeHtml(String value) {
        if (value == null) {
            return "";
        }
        return value
                .replace("&", "&amp;")
                .replace("<", "&lt;")
                .replace(">", "&gt;")
                .replace("\"", "&quot;")
                .replace("'", "&#39;");
    }
}
