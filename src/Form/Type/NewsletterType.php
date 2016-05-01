<?php
	namespace LMQP\Form\Type;
	
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	
	class NewsletterType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder->add('email', 'email');
		}
		
		public function getName()
		{
			return 'newsletter';
		}
	}
?>