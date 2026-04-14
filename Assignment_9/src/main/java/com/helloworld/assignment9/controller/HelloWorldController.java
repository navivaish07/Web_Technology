package com.helloworld.assignment9.controller;

import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class HelloWorldController {

    @GetMapping(value = "/", produces = MediaType.TEXT_HTML_VALUE)
    public String showHelloWorldPage() {
        return """
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Hello World - Spring Boot</title>
                    <style>
                        :root {
                            color-scheme: light;
                            --bg-start: #f8fafc;
                            --bg-end: #dbeafe;
                            --card-bg: #ffffff;
                            --text-main: #0f172a;
                            --text-soft: #475569;
                            --accent: #2563eb;
                            --accent-dark: #1d4ed8;
                        }

                        * {
                            box-sizing: border-box;
                        }

                        body {
                            margin: 0;
                            min-height: 100vh;
                            display: grid;
                            place-items: center;
                            padding: 24px;
                            font-family: Arial, Helvetica, sans-serif;
                            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
                            color: var(--text-main);
                        }

                        .card {
                            width: min(720px, 100%);
                            background: var(--card-bg);
                            border-radius: 20px;
                            padding: 36px;
                            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.16);
                        }

                        .badge {
                            display: inline-block;
                            margin-bottom: 18px;
                            padding: 8px 14px;
                            border-radius: 999px;
                            background: #dbeafe;
                            color: var(--accent-dark);
                            font-size: 14px;
                            font-weight: 700;
                            letter-spacing: 0.04em;
                            text-transform: uppercase;
                        }

                        h1 {
                            margin: 0 0 12px;
                            font-size: clamp(32px, 5vw, 52px);
                        }

                        p {
                            margin: 0 0 14px;
                            font-size: 18px;
                            line-height: 1.6;
                            color: var(--text-soft);
                        }

                        code {
                            padding: 2px 8px;
                            border-radius: 6px;
                            background: #eff6ff;
                            color: var(--accent-dark);
                            font-weight: 700;
                        }
                    </style>
                </head>
                <body>
                    <main class="card">
                        <span class="badge">Spring Boot Web Service</span>
                        <h1>Hello World</h1>
                        <p>This webpage is served by a Spring Boot application running on its embedded server.</p>
                        <p>For the basic REST response, open <code>/api/hello</code> in the browser.</p>
                    </main>
                </body>
                </html>
                """;
    }

    @GetMapping("/api/hello")
    public String helloMessage() {
        return "Hello World from Spring Boot!";
    }
}
