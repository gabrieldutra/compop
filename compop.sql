--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interest` (
  `user_id` int(11) NOT NULL,
  `oportunity_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`oportunity_id`),
  KEY `fk_user_has_oportunity_oportunity1_idx` (`oportunity_id`),
  KEY `fk_user_has_oportunity_user1_idx` (`user_id`),
  CONSTRAINT `fk_user_has_oportunity_oportunity1` FOREIGN KEY (`oportunity_id`) REFERENCES `oportunity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_oportunity_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interest`
--

LOCK TABLES `interest` WRITE;
/*!40000 ALTER TABLE `interest` DISABLE KEYS */;
INSERT INTO `interest` VALUES (1,1),(1,2),(1,3),(1,4);
/*!40000 ALTER TABLE `interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oportunity`
--

DROP TABLE IF EXISTS `oportunity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oportunity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `inscription` text,
  `photo` varchar(128) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_oportunity_user_idx` (`creator_id`),
  CONSTRAINT `fk_oportunity_user` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oportunity`
--

LOCK TABLES `oportunity` WRITE;
/*!40000 ALTER TABLE `oportunity` DISABLE KEYS */;
INSERT INTO `oportunity` VALUES (1,1,'Vaga do Rubio',1,0,'Grande Rubio','Acesse o [Google](http://www.google.com.br/)...','https://picsum.photos/600?image=1','2018-12-01 21:42:07','2018-12-01 21:46:42'),(2,1,'Vaga do Dutra',1,0,'Vaga de exemplo','Acesse o [Google](http://www.google.com.br/)...','https://picsum.photos/600?image=123','2018-12-01 21:42:20','2018-12-01 21:47:22'),(3,1,'Teste 1',1,0,'Lorem ipsum...','Entre no [Facebook](http://www.facebook.com).','https://picsum.photos/600?image=872','2018-12-01 21:43:07','2018-12-01 21:47:30'),(4,1,'Exemplo',1,0,'Exemplo...','**E-mail**: gdutra.dev@gmail.com','https://picsum.photos/600?image=777','2018-12-01 21:48:35','2018-12-01 21:48:46');
/*!40000 ALTER TABLE `oportunity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `registry` varchar(45) DEFAULT NULL,
  `receive_email` tinyint(1) NOT NULL DEFAULT '1',
  `level` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(45) DEFAULT NULL,
  `mobile_phone` varchar(45) DEFAULT NULL,
  `about` text,
  `photo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Gabriel','gdutra.dev@gmail.com','7c7972682a536718fb328bc5bbbfd41f','201622040198',1,0,'3133333333','32323232323','Test',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-03 21:10:48
