<?php


class Tagon_GroupsCatalog_Model_Entity_Attribute_Source_Customergroup_Withdefault
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{   
    /**
     * Return all options for the customergroups_groups attributes, i.e. a list of all
     * customer groups with the additional options USE DEFAULT and NONE
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'value' => Tagon_GroupsCatalog_Helper_Data::USE_DEFAULT,
                    'label' => Mage::helper('tagon_groupscatalog')->__(
                        Tagon_GroupsCatalog_Helper_Data::LABEL_DEFAULT
                    )
                ),
                array(
                    'value' => Tagon_GroupsCatalog_Helper_Data::USE_NONE,
                    'label' => Mage::helper('tagon_groupscatalog')->__(
                        Tagon_GroupsCatalog_Helper_Data::LABEL_NONE
                    )
                )
            );
            foreach (Mage::helper('tagon_groupscatalog')->getGroups() as $group) {
                /* @var $group Mage_Customer_Model_Group */
                $this->_options[] = array(
                    'value' => $group->getId(),
                    'label' => $group->getCode(),
                );
            }
        }
        return $this->_options;
    }

    /**
     * Get the label for an option value. If the value is a comma
     * separated string or an array, return an array of matching
     * option labels.
     *
     * @param string|integer $value
     * @return string|array
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();

        if (is_scalar($value) && strpos($value, ',')) {
            $value = explode(',', $value);
        }
        if (is_array($value)) {
            $values = array();
            foreach ($options as $item) {
                if (in_array($item['value'], $value)) {
                    $values[] = $item['label'];
                }
            }
            return $values;
        } else {
            foreach ($options as $item) {
                if ($item['value'] == $value) {
                    return $item['label'];
                }
            }
        }
        return false;
    }

    /**
     * Return the matching option value(s) for the passed option label(s)
     *
     * @param int|string $value A single option label or a comma separated list for multiselect
     * @return null|string
     */
    public function getOptionId($value)
    {
        if (
            $this->getAttribute()->getFrontendInput() === 'multiselect' &&
            (is_array($value) || strpos($value, ',') !== false)
        ) {
            if (is_scalar($value)) {
                $value = explode(',', $value);
            }

            $optionIds = array();
            foreach ($value as $optionValue) {
                $optionIds[] = $this->getOptionId($optionValue);
            }
            return implode(',', $optionIds);
        }

        foreach ($this->getAllOptions() as $option) {
            if (strcasecmp($option['label'], $value) == 0 || $option['value'] == $value) {
                return $option['value'];
            }
        }
        return null;
    }
}
