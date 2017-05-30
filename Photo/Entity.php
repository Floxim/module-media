<?php
namespace Floxim\Media\Photo;

class Entity extends \Floxim\Main\Content\Entity
{

    public function getDefaultBoxFields() {
        return array(
            array(
                'type' => 'image',
                'keyword' => 'image',
                ''
            ),
            array(
                array('keyword' => 'description', 'template' => 'text_value')
            )
        );
    }
}