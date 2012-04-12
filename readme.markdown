NFormBuilder
============

This tool can load metadata from database, doctrine metadata, symfony validation annotations or whatewer you want (if you implement simple interface) and then it helps you create forms in Nette framework.

## config.neon

    # form builder
    formMetadataFactory:
      class: NFormBuilder\Meta\MetadataFactory
      setup:
        - addLoader( NFormBuilder\Meta\Loader\NetteDatabaseLoader( @database::getSupplementalDriver() ) )
    formBuilderFactory: NFormBuilder\BuilderFactory

## Form factory in presenter

    protected function createComponentAddForm()
    {
	    $dbTable = 'blog';

        $form = $this->context->formBuilderFactory
            ->createBuilder($dbTable)
            // or ->createBuilder($dbTable, $form) if you want to update existing form
            ->add('name', 'slug', 'text', 'allowed')
            ->getForm();

        $form->addSubmit('s', 'Add blog post');
        $form->onSuccess[] = array($this, 'addForm_submit');

        return $form;
    }