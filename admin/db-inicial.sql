SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `web_modules` (
  `id` int(11) NOT NULL,
  `shared` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `friendly` varchar(255) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `content` varchar(10) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `father_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `web_module_fields` (
  `id` int(11) NOT NULL,
  `content_id` int(11) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `attributes` text,
  `type` varchar(256) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `father_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `web_noticias` (
  `id` int(11) NOT NULL,
  `shared` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `contenido` text,
  `imagen` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `father_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `web_rol_specs` (
  `specs_id` int(11) NOT NULL,
  `specs` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `web_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `web_type` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `value` tinytext NOT NULL,
  `name` tinytext,
  `description` mediumtext,
  `status_id` varchar(1) DEFAULT 't'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `web_type` (`id`, `type_id`, `value`, `name`, `description`, `status_id`) VALUES
(1, 1, 't', '0', 'Activo', 't'),
(2, 1, 'f', '1', 'No Activo', 't'),
(3, 2, '1', 'Administrador', 'Administrador websites', 't'),
(4, 3, '1', 'Español', 'es', 't'),
(5, 3, '2', 'English', 'en', 'f'),
(8, 4, '0', 'users', 'Usuarios <br/><span class="c_gray">Crear nuevos usuarios, asignarles permisos administrativos.</span>', 't'),
(9, 4, '1', 'noticias_gestor', 'Noticias home <br/><span class="c_gray">Crear editar y eliminar Noticias que se muestran en Home</span>', 't'),
(10, 2, '2', 'Editor', 'usuario editar', 't');

CREATE TABLE `web_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `specs` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `image` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `rol_id` int(1) NOT NULL,
  `dominio` int(11) NOT NULL COMMENT 'referencia al id de la tabla contents',
  `datatime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status_id` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'f'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `web_users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `specs`, `image`, `rol_id`, `dominio`, `datatime`, `status_id`) VALUES
(1, 'Admin', '', 'server@zavgroup.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, '', 0, 0, '2015-09-03 10:00:00', 't');

ALTER TABLE `web_modules` ADD PRIMARY KEY (`id`);
ALTER TABLE `web_module_fields` ADD PRIMARY KEY (`id`);
ALTER TABLE `web_noticias` ADD PRIMARY KEY (`id`);
ALTER TABLE `web_rol_specs` ADD PRIMARY KEY (`specs_id`);
ALTER TABLE `web_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);
ALTER TABLE `web_type`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `web_users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `web_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `web_module_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `web_noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `web_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `web_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;