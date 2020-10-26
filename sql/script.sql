CREATE TABLE `formaberto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Nome` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `CPF` varchar(150) NOT NULL,
  `Telefone` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `formrestrito` (
  `Id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Nome` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `CPF` varchar(150) NOT NULL,
  `Senha` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
