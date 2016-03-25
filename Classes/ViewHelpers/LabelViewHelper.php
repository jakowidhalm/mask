<?php

namespace MASK\Mask\ViewHelpers;

/**
 *
 * @package TYPO3
 * @subpackage mask
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Benjamin Butschell bb@webprofil.at>
 *
 */
class LabelViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Utility
     *
     * @var \MASK\Mask\Utility\MaskUtility
     * @inject
     */
    protected $utility;

    /**
     * Returns the label of a field in an element
     *
     * @param string $elementKey Key of Element
     * @param string $fieldKey Key of Field
     * @param array $field whole field, to better determine correct label
     * @param string $table tt_content or pages, to better determine correct label
     * @return string Label
     * @author Benjamin Butschell bb@webprofil.at>
     */
    public function render($elementKey, $fieldKey, $field = NULL, $table = NULL)
    {
        $this->utility = new \MASK\Mask\Utility\MaskUtility($this->objectManager);
        // if we have the whole field configuration
        if ($field) {
            // check if this field is in an repeating field
            if ($field["inlineParent"]) {
                // if yes, the label is in the configuration
                $label = $field["label"];
            } else {
                // otherwise the type can only be tt_content or pages
                if ($table) {
                    // if we have table param, the type must be the table
                    $type = $table;
                } else {
                    // otherwise try to get the label, set param $excludeInlineFields to true
                    $type = $this->utility->getFieldType($fieldKey, $elementKey, true);
                }
                $label = $this->utility->getLabel($elementKey, $fieldKey, $type);
            }
        } else {
            // if we don't have the field configuration, try the best to fetch the type and the correct label
            $type = $this->utility->getFieldType($fieldKey, $elementKey, false);
            $label = $this->utility->getLabel($elementKey, $fieldKey, $type);
        }
        return $label;
    }
}
