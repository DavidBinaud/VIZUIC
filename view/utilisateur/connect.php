<form>
	<fieldset>
		<legend>Page de connexion:</legend>
		<p>
			<input type="hidden" name="action" value="connected">
			<input type="hidden" name="controller" value="utilisateur">
			<label>Identifiant</label>
			<input type="text" name="Identifiant" required
			value="<?php if(isset($Identifiant)) { echo $Identifiant; }?>"><br>
			<label>Password</label>
			<input type="password" name="password" required>
		</p>
		<p>
        	<button class='waves-effect waves-light btn blue accent-3 right' type="submit" value="Envoyer"> Envoyer <i class="material-icons right">send</i> </button>
        </p>
	</fieldset>
</form>
