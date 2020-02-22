<?php /*** SVG Pie Chart ***/
class Pie_Chart 
{
 	var $ChartRadius;
 	var $ChartFontHeight;
 	var $ChartData;
 	//allocate colors
	var $colorBody;
	var $colorBorder;
	var $colorText;
	var $colorSlice;
	// allocate widths
	var $widthBorder;
	var $widthPieSliceBorder;
	var $widthLegendColorBorder;
	// light source
	var $lightHeight;
	var $lightSource;
	
	// Constructor
	//function Pie_Chart(){}
	
  // get x,y pair on cirle, assuming center is 0,0
	function circle_point($degrees, $diameter)
	{
    //avoid problems with doubles
		$degrees += 0.0001;
		$x = cos(deg2rad($degrees)) * ($diameter/2);
		$y = sin(deg2rad($degrees)) * ($diameter/2);
		return (array($x, $y));
	}
  function print_pie_chart()
  {
  	//fill in chart parameters
  	$ChartDiameter = $this->ChartRadius*2;
  	//determine graphic size
    $ChartWidth = $ChartDiameter + 20;
    $ChartHeight = $ChartDiameter + 20 + (($this->ChartFontHeight + 2) * count($this->ChartData));
    //determine total of all values
    $ChartTotal=0;
    foreach($this->ChartData as $Data) $ChartTotal += $Data[0];
    $ChartCenterX = $ChartDiameter/2 + 10;
    $ChartCenterY = $ChartDiameter/2 + 10;
    //set the content type
    header("Content-type: image/svg-xml");
    //mark this as XML
    print('<?xml version="1.0" encoding="iso-8859-1"?>' . "\n");
    //Point to SVG DTD
    print('<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN"	"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">'."\n");
    //start SVG document, set size in "user units"
    print("<svg xml:space=\"preserve\" width=\"5in\" height=\"5in\" viewBox=\"0 0 $ChartWidth $ChartHeight\"\n\txmlns=\"http://www.w3.org/2000/svg\"\n\txmlns:xlink=\"http://www.w3.org/1999/xlink\">\n");
		// define filters
		print('<defs>'."\n");
  	print('<filter id="Shadow" filterUnits="userSpaceOnUse">'."\n");
  	print('  <!--Copyright 1999 Adobe Systems. You may copy, modify, and distribute this file, if you include this notice & do not charge for the distribution. This file is provided "AS-IS" without warranties of any kind, including any implied warranties.-->'."\n");
  	print('	<feGaussianBlur in="SourceAlpha" stdDeviation="4" result="blur"/>'."\n");
    print('	<feOffset in="blur" dx="4" dy="4" result="offsetBlurredAlpha"/>'."\n");
    print('	<feSpecularLighting in="blur" surfaceScale="5" specularConstant="0.9" specularExponent="20" lightColor="white" result="specularOut">'."\n");
    print('	  <feDistantLight azimuth="'.$this->lightSource.'" elevation="'.$this->lightHeight.'"/>'."\n");
    print('	</feSpecularLighting>'."\n");
    print('	<feComposite in="specularOut" in2="SourceAlpha" operator="in" result="specularOut"/>'."\n");
    print('	<feComposite in="SourceGraphic" in2="specularOut" operator="arithmetic" k1="0" k2="1" k3="1" k4="0" result="litPaint"/>'."\n");
    print('	<feMerge>'."\n");
    print('	  <feMergeNode in="offsetBlurredAlpha"/>'."\n");
    print('		<feMergeNode in="litPaint"/>'."\n");
    print('	</feMerge>'."\n");
  	print('</filter>'."\n");
  	print('<filter id="MyFilter" filterUnits="userSpaceOnUse">'."\n");
  	print('  <!--Copyright 1999 Adobe Systems. You may copy, modify, and distribute this file, if you include this notice & do not charge for the distribution. This file is provided "AS-IS" without warranties of any kind, including any implied warranties.-->'."\n");
  	print('	<feGaussianBlur in="SourceAlpha" stdDeviation="4" result="blur"/>'."\n");
    print('	<!--<feOffset in="blur" dx="4" dy="4" result="offsetBlurredAlpha"/>-->'."\n");
    print('	<feSpecularLighting in="blur" surfaceScale="5" specularConstant="0.9" specularExponent="20" lightColor="white" result="specularOut">'."\n");
    print('	  <feDistantLight azimuth="225" elevation="30"/>'."\n");
    print('	</feSpecularLighting>'."\n");
    print('	<feComposite in="specularOut" in2="SourceAlpha" operator="in" result="specularOut"/>'."\n");
    print('	<feComposite in="SourceGraphic" in2="specularOut" operator="arithmetic" k1="0" k2="1" k3="1" k4="0" result="litPaint"/>'."\n");
    print('	<feMerge>'."\n");
    print('	  <!--<feMergeNode in="offsetBlurredAlpha"/>-->'."\n");
    print('		<feMergeNode in="litPaint"/>'."\n");
    print('	</feMerge>'."\n");
  	print('</filter>'."\n");
		print('</defs>'."\n");

    // make background rectangle
    print("\t<rect x=\"0\" y=\"0\" width=\"$ChartWidth\" height=\"$ChartHeight\" style=\"fill:$this->colorBody\" />");
    $Degrees = 0;
    $index = 0;
		print("<g id=\"pie\" style=\"filter:url(#Shadow);\">\n");
    // draw border
    print("\n\n\t<circle cx=\"".($ChartCenterX-1)."\" cy=\"".($ChartCenterY-1)."\" r=\"$this->ChartRadius\" style=\"fill:none; stroke:$this->colorBorder; stroke-width:$this->widthBorder;\" />\n");
		// draw each slice
    foreach($this->ChartData as $Label=>$Data)
    {
      $StartDegrees = round($Degrees);
    	$Degrees += ($Data[0]/$ChartTotal)*360;
    	$EndDegrees = round($Degrees);
    	//$CurrentColor = $Value[($index++)%(count($this->colorSlice))];
			$CurrentColor = $Data[1];
    	print("\n\t<!--$Label: ".$Data[0]." (of $ChartTotal) $StartDegrees to $EndDegrees degrees in $CurrentColor-->\n\t");
			if(!is_null($Data[2])) print("<a xlink:href=\"".$Data[2]."\">\n\t\t");
    	print("<path d=\"");
    	//start at center of circle
    	print("M $ChartCenterX,$ChartCenterY ");
    	//draw out to circle edge
    	list($ArcX, $ArcY) = $this->circle_point($StartDegrees, $ChartDiameter);
    	print("L " . floor($ChartCenterX + $ArcX) . "," . floor($ChartCenterY + $ArcY) . " ");
    	//draw arc
    	list($ArcX, $ArcY) = $this->circle_point($EndDegrees, $ChartDiameter);
    	print("A $this->ChartRadius,$this->ChartRadius 0 0 1 " .
    	floor($ChartCenterX + $ArcX) . "," .
    	floor($ChartCenterY + $ArcY) ." ");
    	//close polygon
    	print("Z\" ");
    	print("style=\"fill:$CurrentColor; stroke:$this->colorBorder; stroke-width:$this->widthPieSliceBorder;\"/>");
			if(!is_null($Data[2])) print("\n\t</a>");
    }
		print("</g>\n");
    // draw legend
    $index=0;
		print("<g id=\"legend\">\n");
    foreach($this->ChartData as $Label=>$Data)
    {
      //$CurrentColor = $this->colorSlice[$index%(count($this->colorSlice))];
      $CurrentColor = $Data[1];
    	$BoxY = $ChartDiameter + 20 + (($index++)*($this->ChartFontHeight+2));
    	$LabelY = $BoxY + $this->ChartFontHeight;
    	//draw color box
			print("\n\t");
			if(!is_null($Data[2])) print("<a xlink:href=\"".$Data[2]."\">\n\t\t");
    	print("<ellipse cx=\"20\" cy=\"".($BoxY+(.5)*$this->ChartFontHeight+1)."\" rx=\"10\" ry=\"".((.5)*$this->ChartFontHeight)."\" style=\"fill:$CurrentColor; stroke:$this->colorBorder; stroke-width:$this->widthLegendColorBorder\" />");
			if(!is_null($Data[2])) print("\n\t</a>");
    	//draw label
			print("\n\t");
			$percent = floor(($Data[0]/$ChartTotal)*100); 
			if(!is_null($Data[2])) print("<a xlink:href=\"".$Data[2]."\">\n\t\t");
    	print("<text x=\"40\" y=\"$LabelY\" style=\"file:$this->colorText; font-size:$this->ChartFontHeight\">$Label: ".$Data[0]." ($percent%)</text>");
			if(!is_null($Data[2])) print("\n\t</a>");
    }
		print("</g>\n");
    //end SVG document
    print("\n</svg>\n");
		exit;
  }
}
?>