<?php

/*
 * The MIT License (MIT)
 * Copyright (c) 2011 Mauro Gonzalez 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN 
 * THE SOFTWARE.
 */

/**
 * Default implementation of {@link HeaderExtractor}. Conforms to OAuth 1.0a
 * 
 * @author Mauro Gonzalez
 *
 */
class HeaderExtractorImpl implements HeaderExtractor
{
  const PARAM_SEPARATOR = ", ";
  const PREAMBLE = "OAuth ";

  /**
   * {@inheritDoc}
   */
  public function extract(OAuthRequest $request)
  {
    $this->checkPreconditions($request);
    $parameters = MapUtils::sort($request->getOauthParameters());
    
    $header = self::PREAMBLE;
    foreach ($parameters as $key => $value) {
      if(strlen($header) > strlen(self::PREAMBLE)) { 
        $header .= self::PARAM_SEPARATOR;
      }
      $header .= sprintf("%s=\"%s\"", $key, URLUtils::percentEncode($value));
    }
    return $header;
  }

  private function checkPreconditions(OAuthRequest $request)
  {
    Preconditions::checkNotNull($request, "Cannot extract a header from a null object");
    $params = $request->getOauthParameters();
    if (!$params) {
      throw new OAuthParametersMissingException($request);
    }
  }

}
