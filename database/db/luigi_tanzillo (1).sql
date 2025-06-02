-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 02, 2025 alle 23:25
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luigi_tanzillo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini_progetti`
--

CREATE TABLE `immagini_progetti` (
  `id` int(11) NOT NULL,
  `progetto_id` int(11) NOT NULL,
  `nome_file` varchar(255) NOT NULL,
  `percorso_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagini_progetti`
--

INSERT INTO `immagini_progetti` (`id`, `progetto_id`, `nome_file`, `percorso_file`) VALUES
(160, 126, '0907-ezgif.com-video-to-gif-converter_1748899452683e167cd80f0.gif', 'assets/uploads/projects/0907-ezgif.com-video-to-gif-converter_1748899452683e167cd80f0.gif');

-- --------------------------------------------------------

--
-- Struttura della tabella `progetti`
--

CREATE TABLE `progetti` (
  `id` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `descrizione_breve` varchar(255) NOT NULL,
  `descrizione_completa` text NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `stato` tinyint(1) DEFAULT 1,
  `titolo_footer` varchar(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `progetti`
--

INSERT INTO `progetti` (`id`, `titolo`, `descrizione_breve`, `descrizione_completa`, `data_creazione`, `stato`, `titolo_footer`) VALUES
(126, 's', 'asd', 'asd', '2025-06-02 21:24:12', 1, 'asd');

-- --------------------------------------------------------

--
-- Struttura della tabella `progetti_ruoli`
--

CREATE TABLE `progetti_ruoli` (
  `progetto_id` int(11) NOT NULL,
  `ruolo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruoli`
--

CREATE TABLE `ruoli` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ruoli`
--

INSERT INTO `ruoli` (`id`, `nome`, `descrizione`) VALUES
(0, 'owner', 'Il proprietario del Sito.'),
(1, 'admin', 'Il ruolo che permette l\'accesso completo al sito'),
(3, 'abbonato', 'Utente abbonato per i contenuti esclusivi.'),
(4, 'utente', 'Il ruolo di default per i nuovi utenti, non permette di accedere alle aree riservate'),
(6, 'about', 'Pagina about.');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `latest_login` datetime DEFAULT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(200) DEFAULT NULL,
  `ruolo` int(11) DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `name`, `surname`, `username`, `email`, `password`, `latest_login`, `data_creazione`, `avatar`, `ruolo`) VALUES
(4, 'Luigi', 'Tanzillo', 'admin', 'admin@admin.com', '123', NULL, '2025-06-01 00:43:29', NULL, 0),
(5, 'prova', 'prova', 'prova', 'pippo@icloud.com', '123', NULL, '2025-06-01 00:50:16', NULL, 4),
(6, 'asd', 'asd', 'asd', 'asd@gmail.com', '123', NULL, '2025-06-02 00:49:50', NULL, 4);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `immagini_progetti`
--
ALTER TABLE `immagini_progetti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `progetto_id` (`progetto_id`);

--
-- Indici per le tabelle `progetti`
--
ALTER TABLE `progetti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_titolo` (`titolo`);

--
-- Indici per le tabelle `progetti_ruoli`
--
ALTER TABLE `progetti_ruoli`
  ADD PRIMARY KEY (`progetto_id`,`ruolo_id`),
  ADD KEY `ruolo_id` (`ruolo_id`);

--
-- Indici per le tabelle `ruoli`
--
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_ruolo` (`ruolo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `immagini_progetti`
--
ALTER TABLE `immagini_progetti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT per la tabella `progetti`
--
ALTER TABLE `progetti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT per la tabella `ruoli`
--
ALTER TABLE `ruoli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `immagini_progetti`
--
ALTER TABLE `immagini_progetti`
  ADD CONSTRAINT `immagini_progetti_ibfk_1` FOREIGN KEY (`progetto_id`) REFERENCES `progetti` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `progetti_ruoli`
--
ALTER TABLE `progetti_ruoli`
  ADD CONSTRAINT `progetti_ruoli_ibfk_1` FOREIGN KEY (`progetto_id`) REFERENCES `progetti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progetti_ruoli_ibfk_2` FOREIGN KEY (`ruolo_id`) REFERENCES `ruoli` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `FK_ruolo` FOREIGN KEY (`ruolo`) REFERENCES `ruoli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
