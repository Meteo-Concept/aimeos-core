<?php

/**
 * @copyright Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Common\Summary\Detail;


/**
 * Default implementation of checkout detail summary HTML client.
 *
 * @package Client
 * @subpackage Html
 */
abstract class Standard
	extends \Aimeos\Client\Html\Common\Client\Factory\Base
	implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{
	/** client/html/common/summary/detail/standard/subparts
	 * List of HTML sub-clients rendered within the common summary detail section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2014.03
	 * @category Developer
	 */
	private $subPartPath = 'client/html/common/summary/detail/standard/subparts';
	private $subPartNames = array();


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string HTML code
	 */
	public function getBody( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid, $tags, $expire );
		}
		$view->detailBody = $html;

		/** client/html/common/summary/detail/standard/template-body
		 * Relative path to the HTML body template of the common summary detail client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the layouts directory (usually in client/html/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/common/summary/detail/standard/template-header
		 */
		$tplconf = 'client/html/common/summary/detail/standard/template-body';
		$default = 'common/summary/detail-body-default.html';

		return $view->render( $this->getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string|null String including HTML tags for the header on error
	 */
	public function getHeader( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getHeader( $uid, $tags, $expire );
		}
		$view->detailHeader = $html;

		/** client/html/common/summary/detail/standard/template-header
		 * Relative path to the HTML header template of the common summary detail client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the HTML code that is inserted into the HTML page header
		 * of the rendered page in the frontend. The configuration string is the
		 * path to the template file relative to the layouts directory (usually
		 * in client/html/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page head
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/common/summary/detail/standard/template-body
		 */
		$tplconf = 'client/html/common/summary/detail/standard/template-header';
		$default = 'common/summary/detail-header-default.html';

		return $view->render( $this->getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function getSubClientNames()
	{
		return $this->getContext()->getConfig()->get( $this->subPartPath, $this->subPartNames );
	}


	/**
	 * Returns a list of tax rates and values for the given basket.
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $basket Basket containing the products, services, etc.
	 * @return array Associative list of tax rates as key and corresponding amounts as value
	 */
	protected function getTaxRates( \Aimeos\MShop\Order\Item\Base\Iface $basket )
	{
		$taxrates = array();

		foreach( $basket->getProducts() as $product )
		{
			$price = $product->getPrice();
			$taxrate = $price->getTaxrate();

			if( isset( $taxrates[$taxrate] ) ) {
				$taxrates[$taxrate] += ( $price->getValue() + $price->getCosts() ) * $product->getQuantity();
			} else {
				$taxrates[$taxrate] = ( $price->getValue() + $price->getCosts() ) * $product->getQuantity();
			}
		}

		try
		{
			$price = $basket->getService( 'delivery' )->getPrice();
			$taxrate = $price->getTaxrate();

			if( isset( $taxrates[$taxrate] ) ) {
				$taxrates[$taxrate] += $price->getValue() + $price->getCosts();
			} else {
				$taxrates[$taxrate] = $price->getValue() + $price->getCosts();
			}
		}
		catch( \Exception $e ) { ; } // if delivery service isn't available

		try
		{
			$price = $basket->getService( 'payment' )->getPrice();
			$taxrate = $price->getTaxrate();

			if( isset( $taxrates[$taxrate] ) ) {
				$taxrates[$taxrate] += $price->getValue() + $price->getCosts();
			} else {
				$taxrates[$taxrate] = $price->getValue() + $price->getCosts();
			}
		}
		catch( \Exception $e ) { ; } // if payment service isn't available

		return $taxrates;
	}
}