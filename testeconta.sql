
--
-- Estrutura para tabela `Ferramenta`
--

CREATE TABLE `Ferramenta` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `link` varchar(300) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tabela truncada antes do insert `Ferramenta`
--

TRUNCATE TABLE `Ferramenta`;
--
-- Despejando dados para a tabela `Ferramenta`
--

INSERT INTO `Ferramenta` (`id`, `title`, `link`, `description`) VALUES
(21, 'Notion', 'https://notion.so', 'All in one tool to organize teams and ideas. Write, plan, collaborate, and get organized. '),
(22, 'json-server', 'https://github.com/typicode/json-server', 'Fake REST API based on a json schema. Useful for mocking and creating APIs for front-end devs to consume in coding challenges.'),
(23, 'fastify', 'https://www.fastify.io/', 'Extremely fast and simple, low-overhead web framework for NodeJS. Supports HTTP2.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Tags`
--

CREATE TABLE `Tags` (
  `id_tag` int(11) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `id_ferra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tabela truncada antes do insert `Tags`
--

TRUNCATE TABLE `Tags`;
--
-- Despejando dados para a tabela `Tags`
--

INSERT INTO `Tags` (`id_tag`, `tag`, `id_ferra`) VALUES
(123, 'organization', 21),
(124, 'planning', 21),
(125, 'collaboration', 21),
(126, 'writing', 21),
(127, 'calendar', 21),
(128, 'api', 22),
(129, 'json', 22),
(130, 'schema', 22),
(131, 'node', 22),
(132, 'github', 22),
(133, 'rest', 22),
(134, 'web', 23),
(135, 'framework', 23),
(136, 'node', 23),
(137, 'http2', 23),
(138, 'https', 23),
(139, 'localhost', 23);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `Ferramenta`
--
ALTER TABLE `Ferramenta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `Tags`
--
ALTER TABLE `Tags`
  ADD PRIMARY KEY (`id_tag`),
  ADD KEY `FK_Ferra` (`id_ferra`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `Ferramenta`
--
ALTER TABLE `Ferramenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `Tags`
--
ALTER TABLE `Tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `Tags`
--
ALTER TABLE `Tags`
  ADD CONSTRAINT `FK_Ferra` FOREIGN KEY (`id_ferra`) REFERENCES `Ferramenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Tags_ibfk_1` FOREIGN KEY (`id_ferra`) REFERENCES `Ferramenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ferramenta` FOREIGN KEY (`id_ferra`) REFERENCES `Ferramenta` (`id`);
COMMIT;

