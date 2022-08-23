<?php
require_once 'bit-util-php/bitstream.php';
require 'huffmannode.php';
require 'huffmannodequeue.php';

/**
*	Implementation of a Huffman Coding
*	http://en.wikipedia.org/wiki/Huffman_coding
*/
class HuffmanCoding
{
	const SYMBOL_EOF = 'EOF';
	
	/**
	 * 	create a code tree whose weights and symbols come from the sample indicated
	 * 	NOTE: if a character isn't in this sample, it can't be encoded with the generated tree
	 */
	public static function getCharacter ($sample)
	{
		$weights = array ();
		for ($i = 0; $i < strlen ($sample); $i++)
		{
			if (!isset ($weights[$sample[$i]]))
			{
				$weights[$sample[$i]] = 0;
			}
			$weights[$sample[$i]]++;
		}
		$weights[self::SYMBOL_EOF] = 1;	
		asort($weights);
		return $weights;

	}

	public static function createCodeTree ($sample)
	{
		$weights = array ();
		for ($i = 0; $i < strlen ($sample); $i++)
		{
			if (!isset ($weights[$sample[$i]]))
			{
				$weights[$sample[$i]] = 0;
			}
			$weights[$sample[$i]]++;
		}
		$weights[self::SYMBOL_EOF] = 1;	//	add the EOF marker to the encoding
		
		
		$queue = new HuffmanNodeQueue ();
		asort ($weights); //fungsi arsort digunakan untuk mengurutkan array dalam turun menurun sesuai dengan nilainya
		// print_r($weights);
		foreach ($weights as $symbol => $weight)
		{
			$queue->addNode (new HuffmanNode ($symbol, $weight));
		}
		
		while ($nodes = $queue->popTwoNodes ())
		{
			$parentNode = HuffmanNode::join ($nodes[0], $nodes[1]);
			$queue->addNode ($parentNode);
		}
		// var_dump($queue);
		
		return $queue->getOnlyNode ();
	}
	
	/**
	 * 	encode the given data using the Huffman tree
	 */
	public static function encode ($data, HuffmanNode $codeTree)
	{
		$codeHash = array ();
		$codeTree->getCodeHash ($codeHash);
		$stream = new BitStreamWriter ();
		for ($i = 0; $i < strlen($data); $i++)
		{
			$symbol = $data[$i];
			if (isset ($codeHash[$symbol]))
			{
				$stream->writeString ($codeHash[$symbol]);
			}
			else
			{
				throw new Exception ("NOTE: Cannot encode symbol {$symbol}. It was not found in the encoding tree.");
			}
			
		}
		$stream->writeString ($codeHash[self::SYMBOL_EOF]); //hasil encoding dalam bentuk objek
		$encodedTree = (string) $codeTree; //kode huffman diubah kedalam bentuk string
		// print_r(strlen($encodedTree)); echo"<br>";
		$encodedData = $stream->getData (); //mendapatkan hasil encoding data dalam bentuk string
		// print_r(strlen($encodedData));	
		return $encodedTree . $encodedData;  //mengembalikan sebagai penggabungan string kdoe huffman dan string hasil encoding
	}
	
	/**
	 * 	decode the data using the code tree
	 */
	public static function decode ($data)
	{
		$rootNode = HuffmanNode::loadFromString ($data);
		$currentNode = $rootNode;
		$reader = new BitStreamReader ($data);	//mengambil data encoding yang akan ddidecode	
		$decoded = "";
		while (true)
		{
			if ($currentNode->isLeaf ())
			{
				$nextSymbol = $currentNode->getSymbol ();
				if ($nextSymbol === self::SYMBOL_EOF)
				{
					return $decoded;
				}
				else
				{
					$decoded .= $nextSymbol;
					$currentNode = $rootNode;
					// print_r($currentNode);
				}
			}
			else
			{
				$bit = $reader->readBit ();
				if ($bit === null)
				{
					throw new Exception ('Reached the end of the encoded data, but did not find the EOF symbol.');
				}
				else
				{
					$currentNode = $bit 
						? $currentNode->getRightChild ()
						: $currentNode->getLeftChild ();
				}
			}
		}
	}
}

