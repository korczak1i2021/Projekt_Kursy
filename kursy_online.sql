CREATE DATABASE IF NOT EXISTS kursy_online;
USE kursy_online;

CREATE TABLE Uzytkownicy (
    uzytkownik_id INT AUTO_INCREMENT PRIMARY KEY,
    imie_i_nazwisko VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    data_rejestracji DATE NOT NULL
);

CREATE TABLE Instruktorzy (
    instruktor_id INT AUTO_INCREMENT PRIMARY KEY,
    imie_i_nazwisko VARCHAR(255) NOT NULL,
    bio TEXT,
    obszar_specjalizacji VARCHAR(255)
);

CREATE TABLE Kursy (
    kurs_id INT AUTO_INCREMENT PRIMARY KEY,
    tytul VARCHAR(255) NOT NULL,
    opis TEXT,
    instruktor_id INT,
    FOREIGN KEY (instruktor_id) REFERENCES Instruktorzy(instruktor_id)
);

CREATE TABLE Zapisania (
    zapisanie_id INT AUTO_INCREMENT PRIMARY KEY,
    uzytkownik_id INT,
    kurs_id INT,
    data_zapisania DATE NOT NULL,
    FOREIGN KEY (uzytkownik_id) REFERENCES Uzytkownicy(uzytkownik_id),
    FOREIGN KEY (kurs_id) REFERENCES Kursy(kurs_id)
);

CREATE TABLE Certyfikaty (
    certyfikat_id INT AUTO_INCREMENT PRIMARY KEY,
    uzytkownik_id INT,
    kurs_id INT,
    data_wydania DATE NOT NULL,
    FOREIGN KEY (uzytkownik_id) REFERENCES Uzytkownicy(uzytkownik_id),
    FOREIGN KEY (kurs_id) REFERENCES Kursy(kurs_id)
);

INSERT INTO Uzytkownicy (imie_i_nazwisko, email, data_rejestracji) VALUES
('Jan Kowalski', 'jan@example.com', '2024-01-15'),
('Anna Nowak', 'anna@example.com', '2024-02-12'),
('Piotr Wiśniewski', 'piotr@example.com', '2024-03-10'),
('Katarzyna Wójcik', 'katarzyna@example.com', '2024-04-05'),
('Marek Lewandowski', 'marek@example.com', '2024-05-01');

INSERT INTO Instruktorzy (imie_i_nazwisko, bio, obszar_specjalizacji) VALUES
('Dr. Kowalski', 'Ekspert AI', 'Sztuczna Inteligencja'),
('Dr. Nowak', 'Specjalistka Data Science', 'Data Science'),
('Dr. Wiśniewski', 'Programista PHP', 'Web Development'),
('Dr. Wójcik', 'Projektant UX', 'Design'),
('Dr. Lewandowski', 'Architekt Chmur', 'Cloud Computing');

INSERT INTO Kursy (tytul, opis, instruktor_id) VALUES
('Wprowadzenie do AI', 'Podstawy sztucznej inteligencji.', 1),
('Zaawansowana analiza danych', 'Praktyczne techniki data science.', 2),
('PHP dla początkujących', 'Tworzenie stron internetowych.', 3),
('UX/UI Design', 'Projektowanie doświadczeń użytkownika.', 4),
('Chmura od podstaw', 'Wprowadzenie do cloud computing.', 5);

INSERT INTO Zapisania (uzytkownik_id, kurs_id, data_zapisania) VALUES
(1, 1, '2024-01-20'),
(2, 2, '2024-02-15'),
(3, 3, '2024-03-15'),
(4, 4, '2024-04-10'),
(5, 5, '2024-05-05');

INSERT INTO Certyfikaty (uzytkownik_id, kurs_id, data_wydania) VALUES
(1, 1, '2024-04-20'),
(2, 2, '2024-05-15'),
(3, 3, '2024-06-10'),
(4, 4, '2024-07-01'),
(5, 5, '2024-08-05');