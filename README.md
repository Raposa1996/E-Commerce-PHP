Banco de Dados

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/01/2025 às 20:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `data_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `comentario`, `data_hora`) VALUES
(1, 'Gostei da camiseta', '2025-01-27 19:09:25'),
(2, 'Gostei da camiseta', '2025-01-27 19:15:27'),
(3, 'Gostei da camiseta', '2025-01-27 19:16:01'),
(4, 'Gostei da camiseta', '2025-01-27 19:16:24'),
(5, 'Gostei da camiseta', '2025-01-27 19:17:48'),
(6, 'Gostei da camiseta', '2025-01-27 19:18:11'),
(7, 'Gostei da camiseta', '2025-01-27 19:19:12'),
(8, 'Gostei da camiseta', '2025-01-27 19:20:39'),
(9, 'Gostei da camiseta', '2025-01-27 19:20:49'),
(10, 'Gostei da camiseta', '2025-01-27 19:22:20'),
(11, 'Gostei da camiseta', '2025-01-27 19:23:03'),
(12, 'Gostei da camiseta', '2025-01-27 19:23:37'),
(13, 'Gostei da camiseta', '2025-01-27 19:25:56'),
(14, 'Gostei da camiseta', '2025-01-27 19:26:32'),
(15, 'Gostei da camiseta', '2025-01-27 19:28:06'),
(16, 'Gostei da camiseta', '2025-01-27 19:28:48'),
(17, 'Gostei da camiseta', '2025-01-27 19:29:33'),
(18, 'Gostei da camiseta', '2025-01-27 19:30:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `produto_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `imagem`) VALUES
(1, 'Camiseta Estampada', 'Camiseta de algodão com estampa exclusiva.', 49.90, 'imagens/camiseta1.jpg'),
(2, 'Tênis Esportivo', 'Tênis confortável para atividades físicas e uso diário.', 199.90, 'imagens/tenis1.jpg'),
(3, 'Notebook Dell', 'Notebook de 15 polegadas com processador Intel Core i5.', 2999.00, 'imagens/notebook1.jpg'),
(4, 'Fone de Ouvido Bluetooth', 'Fone de ouvido sem fio, com ótima qualidade de som.', 129.90, 'imagens/fone1.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'João Silva', 'joao@example.com', 'senha123'),
(2, 'Higor', 'higordias.jobs@gmail.com', '$2y$10$OogTVADvCUZo48Wt0oEhzew98iDgkUd6Wctvn/B204LxJNJRvjA6y');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
