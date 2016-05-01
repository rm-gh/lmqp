<?php
	namespace LMQP\Form\Type;
	
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	
	class BookingType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder->add('firstname', 'text')
					->add('lastname', 'text')
					->add('email', 'email')
					->add('phone', 'text')
					->add('address','textarea')
					->add('activity','text')
					->add('agreement','checkbox');
		}
		
		public function getName()
		{
			return 'booking';
		}
	}
?>