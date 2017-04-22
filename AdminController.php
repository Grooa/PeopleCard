<?php
/**
 * @package   ImpressPages
 */

namespace Plugin\PeopleCard;


class AdminController
{

    /**
     * WidgetSkeleton.js ask to provide widget management popup HTML. This controller does this.
     * @return \Ip\Response\Json
     * @throws \Ip\Exception\View
     */
    public function widgetPopupHtml()
    {
        $widgetId = ipRequest()->getQuery('widgetId');
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        //create form prepopulated with current widget data
        $form = $this->managementForm($widgetData);

        //Render form and popup HTML
        $viewData = array(
            'form' => $form
        );
        $popupHtml = ipView('view/editPopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );
        //Return rendered widget management popup HTML in JSON format
        return new \Ip\Response\Json($data);
    }


    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function checkForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->managementForm();
        $data = $form->filterValues($data); //filter post data to remove any non form specific items
        $errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3
        if ($errors) {
            //error
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //success
            unset($data['aa']);
            unset($data['securityToken']);
            unset($data['antispam']);
            $data = array (
                'status' => 'ok',
                'data' => $data

            );
        }
        return new \Ip\Response\Json($data);
    }

    protected function managementForm($widgetData = array())
    {
        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'PeopleCard.checkForm'
            )
        );
        $form->addField($field);

        //Input fields to adjust widget settings

//        $field = new \Ip\Form\Field\Text(
//            array(
//                'name' => 'title',
//                'label' => 'Title',
//                'value' => empty($widgetData['title']) ? null : $widgetData['title']
//            )
//        );
//        $field->addValidator('Required');
//        $form->addField($field);
//
//        $field = new \Ip\Form\Field\Textarea(
//            array(
//                'name' => 'text',
//                'label' => 'Text',
//                'value' => empty($widgetData['text']) ? null : $widgetData['text']
//            )
//        );


        //ADD YOUR OWN FIELDS
        $urlField = new \Ip\Form\Field\Url([
            'name' => 'url',
            'label' => 'Page',
            'value' => !empty($widgetData['url']) ? $widgetData['url'] : null,
            'default' => null
        ]);

        $nameField = new \Ip\Form\Field\Text([
            'name' => 'name',
            'label' => 'Name',
            'value' => !empty($widgetData['name']) ? $widgetData['name'] : null
        ]);
        $nameField->addValidator('Required');

        $posField = new \Ip\Form\Field\Text([
            'name' => 'position',
            'label' => 'Position',
            'value' => !empty($widgetData['position']) ? $widgetData['position'] : null
        ]);

        $imgField = new \Ip\Form\Field\RepositoryFile([
            'name' => 'img',
            'label' => 'Profile photo',
            'value' => !empty($widgetData['img']) ? $widgetData['img'] : null,
            'preview' => 'thumbnails', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png') //optional
        ]);

        // Register fields to form
        $form->addField($field);
        $form->addField($urlField);
        $form->addField($nameField);
        $form->addField($posField);
        $form->addField($imgField);

        return $form;
    }



}
