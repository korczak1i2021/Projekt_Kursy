<?php

require_once 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type'])) {
        $form_type = $_POST['form_type'];

        if ($form_type == "add_user") {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $registration_date = $_POST['registration_date'];

            $sql = "INSERT INTO Uzytkownicy (imie_i_nazwisko, email, data_rejestracji) 
                    VALUES ('$name', '$email', '$registration_date')";
            mysqli_query($conn, $sql);

        } elseif ($form_type == "add_instructor") {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $bio = mysqli_real_escape_string($conn, $_POST['bio']);
            $expertise_area = mysqli_real_escape_string($conn, $_POST['expertise_area']);

            $sql = "INSERT INTO Instruktorzy (imie_i_nazwisko, bio, obszar_specjalizacji) 
                    VALUES ('$name', '$bio', '$expertise_area')";
            mysqli_query($conn, $sql);

        } elseif ($form_type == "add_course") {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $instructor_id = (int) $_POST['instructor_id'];

            $sql = "INSERT INTO Kursy (tytul, opis, instruktor_id) 
                    VALUES ('$title', '$description', $instructor_id)";
            mysqli_query($conn, $sql);

        } elseif ($form_type == "add_enrollment") {
            $user_id = (int) $_POST['user_id'];
            $course_id = (int) $_POST['course_id'];
            $enrollment_date = $_POST['enrollment_date'];

            $sql = "INSERT INTO Zapisania (uzytkownik_id, kurs_id, data_zapisania) 
                    VALUES ($user_id, $course_id, '$enrollment_date')";
            mysqli_query($conn, $sql);

        } elseif ($form_type == "add_certificate") {
            $user_id = (int) $_POST['user_id'];
            $course_id = (int) $_POST['course_id'];
            $issue_date = $_POST['issue_date'];

            $sql = "INSERT INTO Certyfikaty (uzytkownik_id, kurs_id, data_wydania) 
                    VALUES ($user_id, $course_id, '$issue_date')";
            mysqli_query($conn, $sql);
        }
    }

    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kursy Wojtek Korczak</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Panel Admina - Kursy Online</h1>

<div class="section">
    <h2>Użytkownicy</h2>
    <table>
        <tr><th>ID</th><th>Imię i nazwisko</th><th>Email</th><th>Data rejestracji</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM Uzytkownicy");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['uzytkownik_id']}</td><td>{$row['imie_i_nazwisko']}</td><td>{$row['email']}</td><td>{$row['data_rejestracji']}</td></tr>";
        }
        ?>
    </table>

    <form method="post" class="form">
        <input type="hidden" name="form_type" value="add_user">
        <input type="text" name="name" placeholder="Imię i nazwisko" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="date" name="registration_date" required>
        <input type="submit" value="Dodaj użytkownika">
    </form>
</div>


<div class="section">
    <h2>Instruktorzy</h2>
    <table>
        <tr><th>ID</th><th>Imię i nazwisko</th><th>Bio</th><th>Specjalizacja</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM Instruktorzy");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['instruktor_id']}</td><td>{$row['imie_i_nazwisko']}</td><td>{$row['bio']}</td><td>{$row['obszar_specjalizacji']}</td></tr>";
        }
        ?>
    </table>

    <form method="post" class="form">
        <input type="hidden" name="form_type" value="add_instructor">
        <input type="text" name="name" placeholder="Imię i nazwisko" required>
        <textarea name="bio" placeholder="Bio" required></textarea>
        <input type="text" name="expertise_area" placeholder="Specjalizacja" required>
        <input type="submit" value="Dodaj instruktora">
    </form>
</div>

<div class="section">
    <h2>Kursy</h2>
    <table>
        <tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Instruktor ID</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM Kursy");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['kurs_id']}</td><td>{$row['tytul']}</td><td>{$row['opis']}</td><td>{$row['instruktor_id']}</td></tr>";
        }
        ?>
    </table>

    <form method="post" class="form">
        <input type="hidden" name="form_type" value="add_course">
        <input type="text" name="title" placeholder="Tytuł" required>
        <textarea name="description" placeholder="Opis" required></textarea>
        <input type="number" name="instructor_id" placeholder="Instruktor ID" required>
        <input type="submit" value="Dodaj kurs">
    </form>
</div>


<div class="section">
    <h2>Zapisy</h2>
    <table>
        <tr><th>ID</th><th>Użytkownik ID</th><th>Kurs ID</th><th>Data zapisania</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM Zapisania");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['zapisanie_id']}</td><td>{$row['uzytkownik_id']}</td><td>{$row['kurs_id']}</td><td>{$row['data_zapisania']}</td></tr>";
        }
        ?>
    </table>

    <form method="post" class="form">
        <input type="hidden" name="form_type" value="add_enrollment">
        <input type="number" name="user_id" placeholder="Użytkownik ID" required>
        <input type="number" name="course_id" placeholder="Kurs ID" required>
        <input type="date" name="enrollment_date" required>
        <input type="submit" value="Dodaj zapis">
    </form>
</div>


<div class="section">
    <h2>Certyfikaty</h2>
    <table>
        <tr><th>ID</th><th>Użytkownik ID</th><th>Kurs ID</th><th>Data wydania</th></tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM Certyfikaty");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['certyfikat_id']}</td><td>{$row['uzytkownik_id']}</td><td>{$row['kurs_id']}</td><td>{$row['data_wydania']}</td></tr>";
        }
        ?>
    </table>

    <form method="post" class="form">
        <input type="hidden" name="form_type" value="add_certificate">
        <input type="number" name="user_id" placeholder="Użytkownik ID" required>
        <input type="number" name="course_id" placeholder="Kurs ID" required>
        <input type="date" name="issue_date" required>
        <input type="submit" value="Dodaj certyfikat">
    </form>
</div>

<div class="section">
    <h2>Pierwsi zapisani użytkownicy na każdy kurs</h2>
    <table>
        <tr><th>ID kursu</th><th>Imię i nazwisko użytkownika</th><th>Data zapisania</th></tr>
        <?php
        $result2 = mysqli_query($conn, "
            SELECT 
                kurs_id,
                imie_i_nazwisko,
                data_zapisania
            FROM (
                SELECT 
                    kursy_online.zapisania.kurs_id,
                    kursy_online.uzytkownicy.imie_i_nazwisko,
                    kursy_online.zapisania.data_zapisania,
                    ROW_NUMBER() OVER (
                        PARTITION BY kursy_online.zapisania.kurs_id 
                        ORDER BY kursy_online.zapisania.data_zapisania ASC
                    ) AS numer
                FROM 
                    kursy_online.zapisania
                JOIN 
                    kursy_online.uzytkownicy 
                    ON kursy_online.zapisania.uzytkownik_id = kursy_online.uzytkownicy.uzytkownik_id
            ) AS sub
            WHERE numer = 1
        ");
        while ($row = mysqli_fetch_assoc($result2)) {
            echo "<tr><td>{$row['kurs_id']}</td><td>{$row['imie_i_nazwisko']}</td><td>{$row['data_zapisania']}</td></tr>";
        }
        ?>
    </table>
</div>

<div class="section">
    <h2>Najstarszy certyfikat</h2>
    <table>
        <tr>
            <th>Imię i nazwisko</th>
            <th>ID certyfikatu</th>
            <th>Data wydania</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "
            SELECT 
                kursy_online.certyfikaty.certyfikat_id,
                kursy_online.uzytkownicy.imie_i_nazwisko,
                kursy_online.certyfikaty.data_wydania
            FROM 
                kursy_online.certyfikaty
            JOIN 
                kursy_online.uzytkownicy 
                ON kursy_online.certyfikaty.uzytkownik_id = kursy_online.uzytkownicy.uzytkownik_id
            WHERE 
                kursy_online.certyfikaty.data_wydania = (
                    SELECT MIN(data_wydania) 
                    FROM kursy_online.certyfikaty
                );
        ");
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['imie_i_nazwisko']}</td>
                <td>{$row['certyfikat_id']}</td>
                <td>{$row['data_wydania']}</td>
            </tr>";
        }
        ?>
    </table>
</div>




<div class="section">
    <h2>Ranking użytkowników wg liczby certyfikatów</h2>
    <table>
        <tr>
            <th>Pozycja</th>
            <th>Imię i nazwisko</th>
            <th>Liczba certyfikatów</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "
            SELECT 
                imie_i_nazwisko,
                liczba_cert,
                RANK() OVER (ORDER BY liczba_cert DESC) AS pozycja
            FROM (
                SELECT 
                    kursy_online.uzytkownicy.imie_i_nazwisko,
                    COUNT(kursy_online.certyfikaty.certyfikat_id) AS liczba_cert
                FROM 
                    kursy_online.uzytkownicy
                LEFT JOIN 
                    kursy_online.certyfikaty 
                    ON kursy_online.uzytkownicy.uzytkownik_id = kursy_online.certyfikaty.uzytkownik_id
                GROUP BY 
                    kursy_online.uzytkownicy.uzytkownik_id
            ) AS ranking
        ");
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['pozycja']}</td>
                <td>{$row['imie_i_nazwisko']}</td>
                <td>{$row['liczba_cert']}</td>
            </tr>";
        }
        ?>
    </table>
</div>



<div class="section">
    <h2>Użytkownicy i liczba zapisów</h2>
    <table>
        <tr>
            <th>Imię i nazwisko</th>
            <th>Liczba zapisów</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "
            SELECT 
                kursy_online.uzytkownicy.uzytkownik_id,
                kursy_online.uzytkownicy.imie_i_nazwisko,
                COUNT(kursy_online.zapisania.kurs_id) 
                    OVER (PARTITION BY kursy_online.uzytkownicy.uzytkownik_id) 
                    AS liczba_zapisow
            FROM 
                kursy_online.uzytkownicy
            LEFT JOIN 
                kursy_online.zapisania 
                ON kursy_online.uzytkownicy.uzytkownik_id = kursy_online.zapisania.uzytkownik_id
        ");
        $uzytkownicy = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['uzytkownik_id'];
            if (!isset($uzytkownicy[$id])) {
                $uzytkownicy[$id] = true;
                echo "<tr>
                    <td>{$row['imie_i_nazwisko']}</td>
                    <td>{$row['liczba_zapisow']}</td>
                </tr>";
            }
        }
        ?>
    </table>
</div>



<div class="section">
    <h2>Ostatnie 5 zapisów</h2>
    <table>
        <tr><th>Użytkownik</th><th>Kurs</th><th>Data zapisania</th></tr>
        <?php
        $result = mysqli_query($conn, "
            SELECT u.imie_i_nazwisko AS uzytkownik, k.tytul AS kurs, z.data_zapisania
            FROM Zapisania z
            JOIN Uzytkownicy u ON z.uzytkownik_id = u.uzytkownik_id
            JOIN Kursy k ON z.kurs_id = k.kurs_id
            ORDER BY z.data_zapisania DESC
            LIMIT 5
        ");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['uzytkownik']}</td><td>{$row['kurs']}</td><td>{$row['data_zapisania']}</td></tr>";
        }
        ?>
    </table>
</div>


</body>
</html>