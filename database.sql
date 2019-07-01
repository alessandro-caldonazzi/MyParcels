-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: alexapar45711
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `spedizioni`
--

DROP TABLE IF EXISTS `spedizioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spedizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `track` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `stato` varchar(255) NOT NULL DEFAULT 'Ignoto',
  `ultima` varchar(255) DEFAULT 'Ignoto',
  `data` varchar(512) DEFAULT 'Ignoto',
  `totale` varchar(2048) NOT NULL DEFAULT 'Ignoto',
  `corriere` varchar(50) NOT NULL DEFAULT 'Ignoto',
  `completo` varchar(255) NOT NULL DEFAULT 'no',
  `aggiunta` varchar(50) NOT NULL DEFAULT 'nulla',
  `oraultima` varchar(20) NOT NULL DEFAULT 'Ignoto',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spedizioni`
--

LOCK TABLES `spedizioni` WRITE;
/*!40000 ALTER TABLE `spedizioni` DISABLE KEYS */;
INSERT INTO `spedizioni` VALUES (45,'Spille','LJ562915872US','giacomofora@icloud.com','Consegnato 10 Giorni','TRENTO TN, Consegnata','2019-06-27 14:16/2019-06-27 10:16/2019-06-27 10:14/2019-06-27 01:05/2019-06-26 22:43/2019-06-26 10:10/2019-06-26 10:09/2019-06-26 08:31/2019-06-26 07:43/2019-06-24 16:41/2019-06-24 09:04/2019-06-19 07:41/2019-06-18 23:43/2019-06-17 18:33/2019-06-27 14:16/2019-06-27 10:16/2019-06-27 10:14/2019-06-27 01:05/2019-06-26 22:43/2019-06-26 10:10/2019-06-26 10:09/2019-06-26 08:31/2019-06-26 07:43/2019-06-24 16:41/2019-06-24 09:04/2019-06-19 07:41/2019-06-18 23:43/2019-06-17 18:33/','TRENTO TN, Consegnata-TRENTO TN, Pronta per la consegna-TRENTO TN, In consegna-VERONA VR, In lavorazione presso il Centro Operativo Postale-VERONA VR, In lavorazione presso il Centro Operativo Postale-MILANO MI, In lavorazione presso il Centro Operativo Postale-Verifica doganale conclusa-Centro Scambi Internazionale, In lavorazione presso il Centro Scambi Internazionale-Centro Scambi Internazionale, In lavorazione presso il Centro Scambi Internazionale-MI, In lavorazione presso il Centro Operativo Postale-Centro Scambi Internazionale, In lavorazione presso il Centro Scambi Internazionale-STATI UNITI, In lavorazione presso il Centro Scambi Internazionale-STATI UNITI, In lavorazione presso il Centro Scambi Internazionale-STATI UNITI, Presa in carico all\'estero-ITALIA, Consegnato - Il tuo articolo è stato consegnato in ITALIA alle 1416 del 27 giugno 2019.-ITALIA, Fuori per la consegna-ITALIA, Arrivo alle Poste-ITALIA, MILANO ROSERIO CSI, Elaborato per struttura-ITALIA, Elaborazione sdoganamento completata-ITALIA, Sdoganamento-ITALIA, Trasformati attraverso la struttura-ITALIA, MILANO, Partito-STATI UNITI, NEWARK, Partito-STATI UNITI, NEWARK, Arrivo-JAMAICA NY INTERNATIONAL DISTRIBUTION CENTER, elaborato attraverso l\'impianto regionale-JAMAICA NY INTERNATIONAL DISTRIBUTION CENTER, Partito USPS RegionalE-JAMAICA NY INTERNATIONAL DISTRIBUTION CENTER, Arrivato alla Struttura Regionale-JAMAICA NY INTERNATIONAL DISTRIBUTION CENTER, Arrivato a USPS Regional Facility-JERSEY CITY NJ NETWORK DISTRIBUTION CENTER, Partito USPS RegionalE-JERSEY CITY NJ NETWORK DISTRIBUTION CENTER, Arrivato a USPS Regional Facility-KEARNY NJ DISTRIBUTION CENTER, Arrivato presso USPS Regional Facility-BELLEVILLE, NJ 07109, Accettato presso USPS Origin Facility-NUTLEY, NJ 07110, Spedizione ricevuta, Accettazione pacco in sospeso-BELLEVILLE, NJ 07109, Etichetta di spedizione creata, USPS in attesa articolo-','USPS','forse','nulla','2019-07-01 08:15'),(46,'Firewall','285234G137489','alecodbo3@gmail.com','Consegnato 1 Giorni','Trento, La spedizione e\' consegnata','2019-06-28 16:02/2019-06-28 09:02/2019-06-28 03:31/2019-06-28 03:31/2019-06-27 17:57/2019-06-27 16:48/','Trento, La spedizione e\' consegnata-Trento, In consegna-Bologna Hub Espresso, La spedizione e\' partita-Bologna Hub Espresso, In transito-Salerno, La spedizione e\' partita-Salerno, La spedizione e\' stata ritirata presso il mittente-','SDA','si','nulla','2019-07-01 08:05'),(47,'F1 2019','F246C41810770','fampitasi@gmail.com','Consegnato 1 Giorni','Reggio Di Calabria RC, Consegnata','2019-06-28 12:35/2019-06-28 10:22/2019-06-28 08:14/2019-06-28 06:09/2019-06-28 03:04/','Reggio Di Calabria RC, Consegnata-Centro Operativo Postale Reggio Di Calabria RC, In consegna-Reggio Di Calabria RC, In lavorazione presso il Centro Operativo Postale-Lamezia Terme CZ, In transito presso il Centro Operativo Postale-Lamezia Terme CZ, In lavorazione presso il Centro Operativo Postale-','Poste Italiane','forse','2019-06-27','2019-07-01 08:15'),(49,'Sda rasoio','915C70029203F','vgl@libero.it','errato','Ignoto','Ignoto','Ignoto','Ignoto','si','2019-06-28','Ignoto'),(50,'Quadro Silvia','TW590768735','fampitasi@gmail.com','Consegnato 2 Giorni','Reggio Calabria, CONSEGNATA, Delfino Stefano','2019-06-26 14:19/2019-06-26 07:24/2019-06-26 05:30/2019-06-26 00:54/2019-06-24 16:06/2019-06-24 00:00/','Reggio Calabria, CONSEGNATA, Delfino Stefano-Reggio Calabria, Consegna prevista nel corso della giornata odierna-Reggio Calabria, Arrivata nella Sede GLS locale.-Centro Di Smistamento - Hub, In transito.-Torino, Partita dalla sede mittente. In transito.-Torino, Spedizione registrata nei nostri sistemi ma non ancora partita-','GLS (IT)','forse','2019-06-29','2019-07-01 08:16'),(51,'Pale','RV923629235CN','Pivincy@alice.it','Prelevato','TORRE SANTA SUSANNA BR, In consegna','2019-06-28 12:15/2019-06-27 09:21/2019-06-26 11:08/2019-06-25 09:39/2019-06-24 18:42/2019-06-21 23:39/2019-05-29 08:52/2019-05-28 23:53/2019-06-28 12:15/2019-06-27 09:21/2019-06-26 11:08/2019-06-25 09:39/2019-06-24 18:42/2019-06-21 23:39/2019-05-29 08:52/2019-05-28 23:53/','TORRE SANTA SUSANNA BR, In consegna-TORRE SANTA SUSANNA BR, Pronta per la consegna-BARI BA, In lavorazione presso il Centro Operativo Postale-NOVARA NO, In lavorazione presso il Centro Operativo Postale-MILANO MI, In lavorazione presso il Centro Operativo Postale-Centro Scambi Internazionale, In lavorazione presso il Centro Scambi Internazionale-CINA, In lavorazione presso il Centro Scambi Internazionale-CINA, Presa in carico all\'estero-Arrivato all\'Ufficio Di consegna d\'Italia-Raggiunto il luogo di arrivo-Lasciare l\'ufficio di swap guangzhou, prossima fermata Guangzhou Exchange-Guangzhou International è stata esportata direttamente sigillata-Arrivo al Guangzhou Swap Bureau-Lascia la Lettera Internazionale Post Guangzhou, la prossima tappa  Guangzhou International -Post Guangzhou Lettera Internazionale s / lui ha ricevuto, il lanciatore Hu Xinlan, Shijing-Ordine logistico creato-','China Post','no','nulla','2019-07-01 08:16'),(52,'Echospot','F227C70467458','Pivincy@alice.it','In Transito','Mesagne BR, In lavorazione presso il Centro Operativo Postale','2019-06-28 14:15/2019-06-28 10:56/2019-06-28 10:12/2019-06-27 07:30/','Mesagne BR, In lavorazione presso il Centro Operativo Postale-Bari BA, In transito presso il Centro Operativo Postale-Bari BA, In lavorazione presso il Centro Operativo Postale-Bologna Hub Espresso BO, In transito-','Poste Italiane','no','nulla','2019-07-01 08:16'),(53,'Sonoff','ID18135418591971CN','Pivincy@alice.it','errato','Ignoto','Ignoto','Ignoto','Ignoto','no','nulla','Ignoto'),(54,'Occhilibit','LP00136556143744','Pivincy@alice.it','errato','Ignoto','Ignoto','Ignoto','Ignoto','no','nulla','Ignoto'),(55,'Caricatore Wireless','RU926201548CN','antoniomaisto@hotmail.it','In Transito','Consegnato al trasporto aereo','2019-06-20 11:00/2019-06-19 21:52/2019-06-20 11:00/2019-06-19 21:52/','CINA, In lavorazione presso il Centro Scambi Internazionale-CINA, Presa in carico all\'estero-Consegnato al trasporto aereo-Lasciare Hangzhou Posta Internazionale, prossima fermata , Hangzhou International Mail Exchange Station-Hangzhou International Mail è stato esportato direttamente-Arrivo a Hangzhou International Mail-Lascia Hangzhou International Small Package Collection Center, prossima fermata Hangzhou International-Hangzhou International Small Package Collection Center ha ricevuto, Agente Sun Luzhu-Ordine logistico creato-','China Post','forse','2019-06-30','2019-07-01 08:17'),(57,'logitech','1ZA0Y3156805696441','talksina@gmail.com','In Transito','Dosson Di Casier Tv, Italia, Arrival Scan','2019-06-29 07:00/2019-06-29 03:00/2019-06-28 18:32/2019-06-28 16:24/2019-06-28 00:11/2019-06-27 17:39/','Dosson Di Casier Tv, Italia, Arrival Scan-Milano, Italia, Partenza Scansione-Milano, Italia, Origin Scan-Milano, Italia, Arrivo Scansione-Eindhoven, Paesi Bassi, Scan di partenza-Paesi Bassi, Ordine elaborato Pronto per UPS-','UPS','no','2019-07-01','2019-07-01 08:14');
/*!40000 ALTER TABLE `spedizioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utenti`
--

DROP TABLE IF EXISTS `utenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(512) NOT NULL,
  `verifica` varchar(2) NOT NULL,
  `token` varchar(8) NOT NULL,
  `usato` varchar(2) NOT NULL DEFAULT 'no',
  `af2` varchar(8) NOT NULL DEFAULT 'nullo',
  `afstate` varchar(2) NOT NULL DEFAULT 'no',
  `sesso` varchar(7) NOT NULL DEFAULT 'male',
  `notifiche` varchar(3) NOT NULL DEFAULT 'off',
  `chatid` varchar(16) NOT NULL DEFAULT 'no',
  `user_tm` varchar(12) DEFAULT 'no',
  `not_tm` varchar(3) DEFAULT 'off',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utenti`
--

LOCK TABLES `utenti` WRITE;
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` VALUES (44,'Giacomo','giacomofora@icloud.com','$2y$10$z4nwaHGIP6x/P11JAl3DzuM49CGsO8asJ2il9yv9vX7vWiZDyHB/C','1','98178303','si','nullo','no','male','on','0','289412232','on'),(49,'Alessandro Caldonazzi','alecodbo3@gmail.com','$2y$10$OpMQSN6TnSNmz/.1XvQhUeA/EuO.GdriUX1IG7amcjUtIu8oGYNuW','1','86411774','si','nullo','no','male','on','0','194391563','on'),(50,'giacomo','zewadeduz@voemail.com','$2y$10$ooL3qzEc1FYueXglt6AfH./Z2ZevFByM7T1nlgVvUWWCh4cTOVxR2','0','88668142','no','nullo','no','male','off','no','no','off'),(51,'a','d4642aa355@himail.online','$2y$10$daaCWN/2bUzZVTkJfKJXVu4/VxGWlN3T7brDA7vE8G/xeYm6wqKXK','1','79211877','si','nullo','no','male','off','no','no','off'),(53,'Loris','fampitasi@gmail.com','$2y$10$6WLDDuGIRpxAW/QhdIS.kutxZM4Ba.O0Xk203KKg16Mlu4DQj8.dy','1','55770283','si','nullo','no','male','off','no','no','off'),(54,'Mario vaglica ','vgl@libero.it','$2y$10$O93hL7C1rDUxZgnk2OX7YOsXWBGWMThmnX5ORzUS5AkPInlFXHpfa','1','70643234','si','nullo','no','male','on','no','504899799','off'),(55,'Vincenzo','Pivincy@alice.it','$2y$10$AnTzotY70YzJPiT9URrozupWU7S5NDr2stEy/giqwyEFtjSAB84PK','1','50192290','si','nullo','no','male','on','no','268431611','off'),(56,'Stefano','ste82m@gmail.com','$2y$10$vf2HMfGBH3n/Xe0zEO79zuOSWsH1X7QUrLGNrgCHFprN4UtYHfbCC','1','22093469','si','nullo','no','male','off','no','8623734','off'),(57,'Antonio','antoniomaisto@hotmail.it','$2y$10$aQsRQNqa4u6FjWj34W1IGORW3SW/Xo0.5KVDaGj1sEjP1KcPOhaTm','1','39202025','si','nullo','no','male','off','no','no','off'),(58,'elena','talksina@gmail.com','$2y$10$Mepw2oYMbiTimrEfO8ctou27I.vhKc8lMO/RvztAc8eRE.2JLiJ3a','1','13384218','si','nullo','no','male','off','no','no','off');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-01  6:18:07
