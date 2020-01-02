<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Item\Product\Attribute;


/**
 * Default product attribute item implementation.
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Order\Item\Product\Attribute\Iface
{
	/**
	 * Initializes the order product attribute instance.
	 *
	 * @param array $values Associative array of order product attribute values. Possible
	 * keys: 'id', 'ordprodid', 'value', 'code', 'mtime'
	 */
	public function __construct( array $values = [] )
	{
		parent::__construct( 'order.product.attribute.', $values );
	}


	/**
	 * Returns the ID of the site the item is stored
	 *
	 * @return string|null Site ID (or null if not available)
	 */
	public function getSiteId()
	{
		return $this->get( 'order.product.attribute.siteid' );
	}


	/**
	 * Sets the site ID of the item.
	 *
	 * @param string $value Unique site ID of the item
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setSiteId( $value )
	{
		return $this->set( 'order.product.attribute.siteid', (string) $value );
	}


	/**
	 * Returns the original attribute ID of the product attribute item.
	 *
	 * @return string Attribute ID of the product attribute item
	 */
	public function getAttributeId()
	{
		return (string) $this->get( 'order.product.attribute.attributeid', '' );
	}


	/**
	 * Sets the original attribute ID of the product attribute item.
	 *
	 * @param string $id Attribute ID of the product attribute item
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setAttributeId( $id )
	{
		return $this->set( 'order.product.attribute.attributeid', (string) $id );
	}


	/**
	 * Returns the ID of the ordered product as parent
	 *
	 * @return string|null ID of the ordered product
	 */
	public function getParentId()
	{
		return $this->get( 'order.product.attribute.parentid' );
	}


	/**
	 * Sets the ID of the ordered product as parent
	 *
	 * @param string $id ID of the ordered product
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setParentId( $id )
	{
		return $this->set( 'order.product.attribute.parentid', (string) $id );
	}


	/**
	 * Returns the value of the product attribute.
	 *
	 * @return string Value of the product attribute
	 */
	public function getType()
	{
		return (string) $this->get( 'order.product.attribute.type', '' );
	}


	/**
	 * Sets the value of the product attribute.
	 *
	 * @param string $type Type of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setType( $type )
	{
		return $this->set( 'order.product.attribute.type', $this->checkCode( $type ) );
	}


	/**
	 * Returns the code of the product attibute.
	 *
	 * @return string Code of the attribute
	 */
	public function getCode()
	{
		return (string) $this->get( 'order.product.attribute.code', '' );
	}


	/**
	 * Sets the code of the product attribute.
	 *
	 * @param string $code Code of the attribute
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setCode( $code )
	{
		return $this->set( 'order.product.attribute.code', $this->checkCode( $code, 255 ) );
	}


	/**
	 * Returns the localized name of the product attribute.
	 *
	 * @return string Localized name of the product attribute
	 */
	public function getName()
	{
		return (string) $this->get( 'order.product.attribute.name', '' );
	}


	/**
	 * Sets the localized name of the product attribute.
	 *
	 * @param string $name Localized name of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setName( $name )
	{
		return $this->set( 'order.product.attribute.name', (string) $name );
	}


	/**
	 * Returns the value of the product attribute.
	 *
	 * @return string|array Value of the product attribute
	 */
	public function getValue()
	{
		return $this->get( 'order.product.attribute.value', '' );
	}


	/**
	 * Sets the value of the product attribute.
	 *
	 * @param string|array $value Value of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setValue( $value )
	{
		return $this->set( 'order.product.attribute.value', $value );
	}


	/**
	 * Returns the quantity of the product attribute.
	 *
	 * @return integer Quantity of the product attribute
	 */
	public function getQuantity()
	{
		return (int) $this->get( 'order.product.attribute.quantity', 1 );
	}


	/**
	 * Sets the quantity of the product attribute.
	 *
	 * @param integer $value Quantity of the product attribute
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function setQuantity( $value )
	{
		return $this->set( 'order.product.attribute.quantity', (int) $value );
	}


	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType()
	{
		return 'order/product/attribute';
	}


	/**
	 * Copys all data from a given attribute item.
	 *
	 * @param \Aimeos\MShop\Attribute\Item\Iface $item Attribute item to copy from
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function copyFrom( \Aimeos\MShop\Attribute\Item\Iface $item )
	{
		$this->setSiteId( $item->getSiteId() );
		$this->setAttributeId( $item->getId() );
		$this->setName( $item->getName() );
		$this->setCode( $item->getType() );
		$this->setValue( $item->getCode() );

		$this->setModified();

		return $this;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface Order product attribute item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'order.product.attribute.siteid': !$private ?: $item = $item->setSiteId( $value ); break;
				case 'order.product.attribute.attrid': !$private ?: $item = $item->setAttributeId( $value ); break;
				case 'order.product.attribute.parentid': !$private ?: $item = $item->setParentId( $value ); break;
				case 'order.product.attribute.type': $item = $item->setType( $value ); break;
				case 'order.product.attribute.code': $item = $item->setCode( $value ); break;
				case 'order.product.attribute.value': $item = $item->setValue( $value ); break;
				case 'order.product.attribute.name': $item = $item->setName( $value ); break;
				case 'order.product.attribute.quantity': $item = $item->setQuantity( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$list = parent::toArray( $private );

		$list['order.product.attribute.type'] = $this->getType();
		$list['order.product.attribute.code'] = $this->getCode();
		$list['order.product.attribute.name'] = $this->getName();
		$list['order.product.attribute.value'] = $this->getValue();
		$list['order.product.attribute.quantity'] = $this->getQuantity();

		if( $private === true )
		{
			$list['order.product.attribute.attrid'] = $this->getAttributeId();
			$list['order.product.attribute.parentid'] = $this->getParentId();
		}

		return $list;
	}
}