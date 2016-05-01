<?php
	namespace LMQP\Form\Type;
	
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	
	class MessageType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder->add('firstname', 'text')
					->add('lastname', 'text')
					->add('email', 'email')
					->add('phone', 'text', array('required' => false))
					->add('message','textarea');
		}
		
		public function getName()
		{
			return 'message';
		}
	}
?>