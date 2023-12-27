DROP DATABASE university;
CREATE DATABASE IF NOT EXISTS university;
USE university;

CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_role VARCHAR(255) NOT NULL,
    token VARCHAR(255) UNIQUE,
    end_time TIME
);

CREATE TABLE IF NOT EXISTS student_groups (
    group_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE,
    group_id INT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    patronymic VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (group_id) REFERENCES student_groups(group_id)
);

CREATE TABLE IF NOT EXISTS schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    discipline VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    group_id INT NOT NULL,
    professor INT NOT NULL,
    audience_code VARCHAR(255) NOT NULL,
    secret_code VARCHAR(255) NOT NULL,
    FOREIGN KEY (group_id) REFERENCES student_groups(group_id),
    FOREIGN KEY (professor) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS journal (
	record_id INT PRIMARY KEY AUTO_INCREMENT,
    schedule_id INT NOT NULL,
    student_id INT NOT NULL,
    attendance BOOL NOT NULL default false,
    grade INT,
    FOREIGN KEY (schedule_id) REFERENCES schedules(schedule_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

INSERT INTO users (username, password, user_role) VALUES
('admin', 'pass', 'admin'),

('pr_1', 'pr_pass_1', 'professor'),
('pr_2', 'pr_pass_2', 'professor'),
('pr_3', 'pr_pass_3', 'professor'),
('pr_4', 'pr_pass_4', 'professor'),

('st_6', 'st_pass_6', 'student'),
('st_7', 'st_pass_7', 'student'),
('st_8', 'st_pass_8', 'student'),
('st_9', 'st_pass_9', 'student'),
('st_10', 'st_pass_10', 'student'),
('st_11', 'st_pass_11', 'student'),
('st_12', 'st_pass_12', 'student'),
('st_13', 'st_pass_13', 'student'),
('st_14', 'st_pass_14', 'student'),
('st_15', 'st_pass_15', 'student'),
('st_16', 'st_pass_16', 'student'),
('st_17', 'st_pass_17', 'student'),
('st_18', 'st_pass_18', 'student'),
('st_19', 'st_pass_19', 'student'),
('st_20', 'st_pass_20', 'student'),
('st_21', 'st_pass_21', 'student'),
('st_22', 'st_pass_22', 'student'),
('st_23', 'st_pass_23', 'student'),
('st_24', 'st_pass_24', 'student'),
('st_25', 'st_pass_25', 'student'),
('st_26', 'st_pass_26', 'student'),
('st_27', 'st_pass_27', 'student'),
('st_28', 'st_pass_28', 'student'),
('st_29', 'st_pass_29', 'student'),
('st_30', 'st_pass_30', 'student'),
('st_31', 'st_pass_31', 'student'),
('st_32', 'st_pass_32', 'student'),
('st_33', 'st_pass_33', 'student'),
('st_34', 'st_pass_34', 'student'),
('st_35', 'st_pass_35', 'student'),
('st_36', 'st_pass_36', 'student');

INSERT INTO student_groups (name) VALUES 
('ИКБО-03-21'), 
('ИКБО-13-21'), 
('ИКБО-33-21');

INSERT INTO students (user_id, group_id, first_name, last_name, patronymic) VALUES
(6, 1, 'Иван', 'Иванов', 'Иванович'),
(7, 1, 'Мария', 'Петрова', 'Александровна'),
(8, 1, 'Алексей', 'Смирнов', 'Андреевич'),
(9, 1, 'Екатерина', 'Козлова', 'Дмитриевна'),
(10, 1, 'Сергей', 'Морозов', 'Николаевич'),
(11, 1, 'Анна', 'Васнецова', 'Сергеевна'),
(12, 1, 'Дмитрий', 'Федоров', 'Петрович'),
(13, 1, 'Ольга', 'Соколова', 'Александровна'),
(14, 1, 'Никита', 'Новиков', 'Алексеевич'),
(15, 1, 'Елена', 'Кузнецова', 'Игоревна'),

(16, 2, 'Павел', 'Игнатьев', 'Валентинович'),
(17, 2, 'Маргарита', 'Беляева', 'Артемовна'),
(18, 2, 'Артем', 'Савельев', 'Иванович'),
(19, 2, 'Виктория', 'Тимофеева', 'Павловна'),
(20, 2, 'Игорь', 'Карпов', 'Сергеевич'),
(21, 2, 'Наталья', 'Андреева', 'Федоровна'),
(22, 2, 'Александр', 'Крылов', 'Александрович'),
(23, 2, 'Елена', 'Макарова', 'Викторовна'),
(24, 2, 'Станислав', 'Сазонов', 'Анатольевич'),
(25, 2, 'Кристина', 'Лебедева', 'Дмитриевна'),

(26, 3, 'Григорий', 'Антонов', 'Артемович'),
(27, 3, 'Валентина', 'Богданова', 'Александровна'),
(28, 3, 'Максим', 'Фролов', 'Игоревич'),
(29, 3, 'Анастасия', 'Комарова', 'Владимировна'),
(30, 3, 'Роман', 'Беляков', 'Алексеевич'),
(31, 3, 'Елена', 'Фомина', 'Сергеевна'),
(32, 3, 'Артур', 'Горбунов', 'Петрович'),
(33, 3, 'Вера', 'Аксенова', 'Николаевна'),
(34, 3, 'Денис', 'Тихонов', 'Дмитриевич'),
(35, 3, 'Людмила', 'Захарова', 'Ивановна'),
(36, 3, 'Юрий', 'Логинов', 'Сергеевич');

INSERT INTO schedules (discipline, date, group_id, professor, audience_code, secret_code) VALUES
-- Понедельник
('C++',    '2023-12-25 09:00:00', 1, 2, 'A1', 'G4DSK4B'),
('C++',    '2023-12-25 12:40:00', 2, 3, 'B1', 'H7K3i1D'),
('C#',     '2023-12-25 12:40:00', 3, 4, 'C1', 'F8J2L6G'),
('C#',     '2023-12-25 14:20:00', 1, 5, 'A2', 'AR32R1V'),
('Python', '2023-12-25 14:20:00', 2, 2, 'B2', 'P9K3L2H'),
('C++',    '2023-12-25 18:00:00', 3, 3, 'C2', 'V7H2K6J'),
-- Вторник
('Python', '2023-12-26 09:00:00', 1, 4, 'A1', 'K93HS2L'),
('C#',     '2023-12-26 09:00:00', 2, 5, 'B1', 'L6H7D4S'),
('Python', '2023-12-26 12:40:00', 3, 2, 'C1', 'M8J2H4I'),
('Go',     '2023-12-26 16:20:00', 1, 3, 'A2', 'G9SK14N'),
('Go',     '2023-12-26 16:20:00', 2, 4, 'B2', 'H1K3i0P'),
('Go',     '2023-12-26 18:00:00', 3, 5, 'C2', 'F8J2L7Q'),
-- Среда
('Java',   '2023-12-27 09:00:00', 1, 5, 'A1', 'AR32R3T'),
('Java',   '2023-12-27 10:40:00', 2, 2, 'B1', 'P9K3L6Y'),
('Java',   '2023-12-27 10:40:00', 3, 3, 'C1', 'V7H2K9Z'),
('C++',    '2023-12-27 14:20:00', 1, 2, 'A2', 'K9H12S2X'),
('C#',     '2023-12-27 14:20:00', 2, 5, 'B2', 'L6H2D4U'),
('C#',     '2023-12-27 18:00:00', 3, 5, 'C2', 'K8J1H4M'),
-- Четверг
('PHP',    '2023-12-28 09:00:00', 1, 2, 'A1', 'G4DSK9R'),
('PHP',    '2023-12-28 09:00:00', 2, 3, 'B1', 'H7K3i0I'),
('PHP',    '2023-12-28 12:40:00', 3, 4, 'C1', 'F8J2L7E'),
('PHP',    '2023-12-28 14:20:00', 1, 5, 'A2', 'AR32R2Q'),
('PHP',    '2023-12-28 16:20:00', 2, 2, 'B2', 'P9K3L3D'),
('PHP',    '2023-12-28 16:20:00', 3, 4, 'C2', 'V7H2K0F'),
-- Пятница
('C#',     '2023-12-29 09:00:00', 1, 3, 'A1', 'G4DSK1M'),
('Python', '2023-12-29 10:40:00', 2, 4, 'B1', 'H7K3i2V'),
('Python', '2023-12-29 12:40:00', 3, 5, 'C1', 'F8J2L3Z'),
('Python', '2023-12-29 14:20:00', 1, 2, 'A2', 'AR32R9X'),
('C++',    '2023-12-29 14:20:00', 2, 3, 'B2', 'P9K3L4Y'),
('C++',    '2023-12-29 14:20:00', 3, 4, 'C2', 'V7H2K7U'),
-- Суббота
('Go',     '2023-12-30 10:40:00', 1, 4, 'A1', 'K93HS9I'),
('Java',   '2023-12-30 10:40:00', 2, 5, 'B1', 'L6H7D2K'),
('Java',   '2023-12-30 12:40:00', 3, 2, 'C1', 'N8J2H1M'),
('Java',   '2023-12-30 12:40:00', 1, 3, 'A2', 'G4DSK4A'),
('Go',     '2023-12-30 14:20:00', 2, 4, 'B2', 'H7K3i1D'),
('Go',     '2023-12-30 14:20:00', 3, 5, 'C2', 'F8J2L6G');

INSERT INTO journal (schedule_id, student_id)
SELECT s.schedule_id
     , st.student_id
FROM schedules s
JOIN students st ON s.group_id = st.group_id;