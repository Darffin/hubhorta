<aside>
		<ul>
		<?php
		include_once "comum.php";
		
		if ( is_session_started() === FALSE ) {
			session_start();
		}	
		?>

		<li><a href='/hubhorta/index.php'>Pagina Inicial</a></li>
		<li><a href='/hubhorta/Hortas_disponiveis.php'>Hortas</a></li>

		<?php if(isset($_SESSION["nome_usuario"])){
			if (($_SESSION["permissao"] == 'admin')) echo "<li><a href='/hubhorta/usuario/usuarios.php'>Usuários</a></li>";
			if ($_SESSION["permissao"] == 'admin' || $_SESSION["permissao"] == 'gerenciador') echo "<li><a href='/hubhorta/estoque/itens.php'>Gerenciar Estoque</a></li>";
			if (($_SESSION["permissao"] == 'admin')) echo "<li><a href='/hubhorta/gerenciadores/gerenciadores.php'>Gerenciadores</a></li>";
			echo "<li><a href='/hubhorta/tarefas/tarefas.php'>Tarefas</a></li>";
		}
		?>

		
		</ul>
	</aside>
	<footer>
		<p>© 2025 Equipe HubHorta. HubHorta. Todos os direitos reservados.</p>
	</footer>

</body>

</html>