package model;

class WKHtmlToPdf extends WKHtml
{
	public static var allowedPaperSize = [ "A0", "A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9", "B0", "B1", "B2", "B3", "B4", "B5", "B6", "B7", "B8", "B9", "B10", "C5E", "Comm10E", "DLE", "Executive", "Folio", "Ledger", "Legal", "Letter", "Tabloid" ];
	var _pdfConfig : ConfigPdf;
	public var pdfConfig(get, set) : ConfigPdf;
	public function new(binpath : String)
	{
		allowedFormats = ['pdf', 'ps'];
		super(binpath);
	}

	static var UNIT_PATTERN = ~/^\d+(\.\d+)?\s*(mm|cm|pt|in|pc|bp|sp)$/i;
	public static function validateUnitReal(v : String)
	{
		return UNIT_PATTERN.match(v);
	}

	function get_pdfConfig()
	{
		if(null == _pdfConfig)
		{
			_pdfConfig = new ConfigPdf();
		}
		return _pdfConfig;
	}

	function set_pdfConfig(c : model.ConfigPdf)
	{
		return _pdfConfig = c;
	}

	override function commandOptions()
	{
		var args = [],
			cfg  = pdfConfig;
		if(null != cfg.dpi)
		{
			args.push("--dpi"); args.push("" + cfg.dpi);
		}
		if(true == cfg.grayscale)
		{
			args.push("--grayscale");
		}
		if(null != cfg.imageDpi)
		{
			args.push("--image-dpi"); args.push("" + cfg.imageDpi);
		}
		if(null != cfg.imageQuality)
		{
			args.push("--image-quality"); args.push("" + cfg.imageQuality);
		}
		if(true == cfg.lowQuality)
		{
			args.push("--lowquality");
		}
		if(null != cfg.marginTop)
		{
			args.push("--margin-top"); args.push("" + cfg.marginTop);
		}
		if(null != cfg.marginBottom)
		{
			args.push("--margin-bottom"); args.push("" + cfg.marginBottom);
		}
		if(null != cfg.marginLeft)
		{
			args.push("--margin-left"); args.push("" + cfg.marginLeft);
		}
		if(null != cfg.marginRight)
		{
			args.push("--margin-right"); args.push("" + cfg.marginRight);
		}
		if(false == cfg.portrait)
		{
			args.push("--orientation"); args.push("Landscape");
		}
		if(null != cfg.pageSize)
		{
			args.push("--page-size"); args.push(cfg.pageSize);
		}
		if(null != cfg.pageHeight)
		{
			args.push("--page-height"); args.push(cfg.pageHeight);
		}
		if(null != cfg.pageWidth)
		{
			args.push("--page-width"); args.push(cfg.pageWidth);
		}
		if(null != cfg.title)
		{
			args.push("--title"); args.push(cfg.title);
		}
		if(true == cfg.usePrintMediaType)
		{
			args.push("--print-media-type");
		}
		if(true == cfg.disableSmartShrinking)
		{
			args.push("--disable-smart-shrinking");
		}

		// footers
		if(null != cfg.footerCenter)
		{
			args.push("--footer-center"); args.push(cfg.footerCenter);
		}
		if(null != cfg.footerLeft)
		{
			args.push("--footer-left"); args.push(cfg.footerLeft);
		}
		if(null != cfg.footerRight)
		{
			args.push("--footer-right"); args.push(cfg.footerRight);
		}
		if(null != cfg.footerFontName)
		{
			args.push("--footer-font-name"); args.push(cfg.footerFontName);
		}
		if(null != cfg.footerFontSize)
		{
			args.push("--footer-font-size"); args.push(cfg.footerFontSize);
		}
		if(null != cfg.footerHtml)
		{
			args.push("--footer-html"); args.push(cfg.footerHtml);
		}
		if(null != cfg.footerSpacing)
		{
			args.push("--footer-spacing"); args.push(""+cfg.footerSpacing);
		}
		if(true == cfg.footerLine)
		{
			args.push("--footer-line");
		}
		// headers
		if(null != cfg.headerCenter)
		{
			args.push("--header-center"); args.push(cfg.headerCenter);
		}
		if(null != cfg.headerLeft)
		{
			args.push("--header-left"); args.push(cfg.headerLeft);
		}
		if(null != cfg.headerRight)
		{
			args.push("--header-right"); args.push(cfg.headerRight);
		}
		if(null != cfg.headerFontName)
		{
			args.push("--header-font-name"); args.push(cfg.headerFontName);
		}
		if(null != cfg.headerFontSize)
		{
			args.push("--header-font-size"); args.push(cfg.headerFontSize);
		}
		if(null != cfg.headerHtml)
		{
			args.push("--header-html"); args.push(cfg.headerHtml);
		}
		if(null != cfg.headerSpacing)
		{
			args.push("--header-spacing"); args.push(""+cfg.headerSpacing);
		}
		if(true == cfg.headerLine)
		{
			args.push("--header-line");
		}

		return super.commandOptions().concat(args);
	}
}