<p>Dobrý den,</p>

<p>sdílím s Vámi úkol "<?php echo $task; ?>" v systému <?php echo $this->Html->link('Taskmaster', Router::url('/', true)); ?>.</p>

<p>Přihlásit se můžete na <a href="<?php echo Router::url('/', true); ?>"><?php echo Router::url('/', true); ?></a>.</p>
<p>K přihlášení použijte jako přihlašovací jméno Váš email a toto automaticky vygenerované heslo: <b><?php echo $password; ?></b>. Heslo si můžete později změnit v nastavení účtu.</p>
