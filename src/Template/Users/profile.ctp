<div class="row">
	<div class="col-md-9">
	<?php echo $this->Form->create(null, ['type' => 'file']); ?>
		<fieldset>
			<legend><?php echo __('Preencha seus dados'); ?></legend>
		<?php
			echo $this->Form->input('name', ['label'=>'Seu nome']);
			echo $this->Form->input('description', ['label'=>'Um pouco sobre você','type'=>'textarea']);
			//echo $this->Form->input('photo', ['label'=>'Sua foto','type' => 'file']);
			echo $this->Form->input('email');
			echo $this->Form->input('password', ['label'=>'Sua senha']);
			echo $this->Form->input('avatar', ['type' => 'file']);
			//echo $this->Form->create($entity, ['type' => 'file']);
		?>
		</fieldset>
	<?php echo $this->Form->button(__('Submit')) ?>
	<?php echo $this->Form->end() ?>
	</div>
</div>