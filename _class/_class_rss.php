<?php
   /**
     * Rss
	 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
  	 * @copyright Copyright (c) 2014 - sisDOC.com.br
	 * @access public
     * @version v.0.14.21
	 * @package _class
	 * @subpackage _class_rss.php
    */
class rss
{
	
	var $itens = '';
	var $tela = '';
	var $imagem = '';
	function montar_rss()
	{
		
		// cabeçalho do RSS
		$cr = chr(13).chr(10);
		
		$sx .= '<rss version="2.0">'.$cr;
		$sx .= '<channel>'.$cr;
        /*titulo*/
        $sx .= '<title>Imagens do Sistema</title>'.$cr;
		/*link do site*/
		$sx .= '<link>www.fonzaghi.com.br</link>'.$cr;
		/*Descrição sobre o conteudo do site*/
        $sx .= '<description>Gerador do Imagens</description>'.$cr;
		$sx .= $this->imagem.$cr;
		$sx .= '<language>pt-br</language>'.$cr;
		/*copyright*/
		$sx .= '<copyright>fonzaghi</copyright>'.$cr;
		$sx .= '<lastBuildDate>'.date('Ymd').'</lastBuildDate>'.$cr;
		/*velocidade do refresh*/
		$sx .= '<ttl>20</ttl>'.$cr;
		/*feed do rss*/
		$sx .= $this->itens.$cr;
		$sx .= '</channel>'.$cr;
		$sx .= '</rss>'.$cr;
		$this->tela = $sx;
		return(1);	
	}
	
	function gerar_itens($titulo='',$autor='',$descricao='',$postado='')
	{
		$cr = chr(13).chr(10);
		$this->itens .= '<item>'.$cr;
	    $this->itens .= '<title>'.$titulo.'</title>'.$cr;
	    $this->itens .= '<autor>'.$autor.'</autor>'.$cr;
	    $this->itens .= '<description>'.$descricao.'</description>'.$cr;
	    $this->itens .= '<datePosted>'.$postado.'</datePosted>';
		$this->itens .= '</item>'.$cr;
		return (1);
	}
	
	function gerar_imagens($path,$vpath='')
	{
		$cr = chr(13).chr(10);
		$files = glob($path."*.*");
		$colCnt=0;
		for ($i=1; $i<count ($files); $i++)
		{
			$colCnt++;
			if ($colCnt==1)
			$num = $vpath.'rss/'.$files[$i];
			$imagem ='<url>'.$num.'</url>'.$cr;
			//print substr(substr($num,6,100),0,-4);
			if ($colCnt==4)
			{
				$colCnt=0;
			}
			$this->imagem .= '<image>'.$imagem.'</image>'.$cr; 
		}
		return(1);	
	}
	
}
/* Tags rss
	<author>		Specifies the email address of the author of an RSS item.
	<category>		Specifies a category for an entire RSS feed or for individual RSS items.
	<channel>		Required. Describes an RSS feed with a title, description, and a URL where the RSS can be found.
	<cloud>			Sets up processes that are automatically notified when a feed has been updated.
	<comments>		Specifies a URL where comments about an RSS item can be found.
	<copyright>		Sets copyright information for an RSS feed.
	<description>	Required. Sets a description for an RSS feed/item.
	<docs>			Specifies a URL where the documentation for the RSS version used in the RSS file can be found.
	<enclosure>		Specifies a media file to be included with an RSS item.
	<generator>		Specifies the program used to create your RSS feed.
	<guid>			Stands for Globally Unique Identifier. Sets a string that uniquely identifies an RSS item.
	<image>			Specifies an image to be displayed with an RSS feed (must be gif, jpeg, or png).
	<item>			Required. Sets items in an RSS feed.
	<language>		Specifies the language your RSS feed is written in.
	<lastBuildDate>	Specifies the most recent time the content of an RSS feed was modified.
	<link>			Required. Specifies the URL where an RSS feed/item content can be found.
	<managingEditor>Specifies the email address of the editor of the content of the feed.
	<pubDate>		Specifies the publication date for an RSS feed/item.
	<source>		Specifies the source of an RSS item (if it came from another RSS feed)
	<skipDays>		Specifies the days of the week when feed readers should not update an RSS feed.
	<skipHours>		Specifies the hours of the day when feed readers should not update an RSS feed.
	<textInput>		Specifies a textbox to be displayed with an RSS feed.
	<title>			Required. Sets the title of an RSS feed/item.
	<ttl>			Stands for Time To Live. Specifies how many minutes your RSS feed can stay cached before it is refreshed.
	<webMaster>		Specifies the email address of the webmaster of an RSS feed.
*/

?>