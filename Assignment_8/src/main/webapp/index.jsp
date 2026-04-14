<%@ page import="java.sql.Connection" %>
<%@ page import="java.sql.DriverManager" %>
<%@ page import="java.sql.PreparedStatement" %>
<%@ page import="java.sql.ResultSet" %>
<%@ page import="java.sql.SQLException" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    String url = "jdbc:mysql://127.0.0.1:3307/college_portal?useSSL=false&serverTimezone=UTC";
    String username = "root";
    String password = "";
    String query = "SELECT stud_id, stud_name, `class`, division, city FROM students_info ORDER BY stud_id";
%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Portal</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2933;
            background: #f4f7fb;
        }

        main {
            width: min(1100px, calc(100% - 32px));
            margin: 40px auto;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 32px;
            color: #102a43;
        }

        p {
            margin: 0 0 24px;
            color: #52616b;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            background: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e6edf5;
        }

        th {
            color: #ffffff;
            background: #0f766e;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .message {
            padding: 16px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            background: #ffffff;
        }

        .error {
            color: #8a1c1c;
            border-color: #f5c2c7;
            background: #fff5f5;
        }

        .campus-photo {
            margin: 0 0 24px;
        }

        .campus-photo img {
            display: block;
            width: 100%;
            height: clamp(180px, 28vw, 320px);
            object-fit: cover;
            border-radius: 8px;
        }

        .campus-photo figcaption {
            margin-top: 8px;
            font-size: 13px;
            color: #52616b;
        }

        .campus-photo a {
            color: #0f766e;
        }
    </style>
</head>
<body>
<main>
    <figure class="campus-photo">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Students_on_Campus.jpg"
             alt="Students walking on a college campus">
        <figcaption>
            Photo by Lgc webmaster on
            <a href="https://commons.wikimedia.org/wiki/File:Students_on_Campus.jpg">Wikimedia Commons</a>,
            licensed under
            <a href="https://creativecommons.org/licenses/by-sa/3.0/">CC BY-SA 3.0</a>.
        </figcaption>
    </figure>

    <h1>Student Information</h1>
    <p>College portal records loaded from the students_info database table.</p>

    <%
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            try (
                Connection connection = DriverManager.getConnection(url, username, password);
                PreparedStatement statement = connection.prepareStatement(query);
                ResultSet students = statement.executeQuery()
            ) {
    %>
    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Division</th>
                <th>City</th>
            </tr>
            </thead>
            <tbody>
            <%
                boolean hasRows = false;
                while (students.next()) {
                    hasRows = true;
            %>
            <tr>
                <td><%= students.getInt("stud_id") %></td>
                <td><%= students.getString("stud_name") %></td>
                <td><%= students.getString("class") %></td>
                <td><%= students.getString("division") %></td>
                <td><%= students.getString("city") %></td>
            </tr>
            <%
                }

                if (!hasRows) {
            %>
            <tr>
                <td colspan="5">No student records found.</td>
            </tr>
            <%
                }
            %>
            </tbody>
        </table>
    </div>
    <%
            }
        } catch (ClassNotFoundException | SQLException exception) {
    %>
    <div class="message error">
        Unable to load student information. Please check the database connection and table setup.
        <br>
        Error: <%= exception.getMessage() %>
    </div>
    <%
        }
    %>
</main>
</body>
</html>
