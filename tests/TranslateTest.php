<?php

namespace Edwinhuish\CssToXpath\Tests;

use Edwinhuish\CssToXpath\CssToXpath;
use PHPUnit\Framework\TestCase;

class TranslateTest extends TestCase
{

    public function testSelectors()
    {
        $css_to_xpath = array(
            'a'                           => '//a',
            '*'                           => '//*',
            '* > a'                       => '//*/a',
            '#someid'                     => '//*[@id=\'someid\']',
            'p#someid'                    => '//p[@id=\'someid\']',
            '#some\\.id'                  => '//*[@id=\'some.id\']',
            '#someid.s-class'             => '//*[@id=\'someid\'][contains(concat(\' \', normalize-space(@class), \' \'), \' s-class \')]',
            '#id[_]'                      => '//*[@id=\'id\'][@_]',
            'p a'                         => '//p//a',
            'div, span'                   => '//div|//span',
            'a[href]'                     => '//a[@href]',
            'a[href][rel]'                => '//a[@href][@rel]',
            'a[href="html"]'              => '//a[@href=\'html\']',
            'a[href!="html"]'             => '//a[@href!=\'html\']',
            'a[href*=\'html\']'           => '//a[contains(@href, \'html\')]',
            '[href*=\'html\']'            => '//*[contains(@href, \'html\')]',
            '[href^=\'html\']'            => '//*[starts-with(@href, \'html\')]',
            'meta[http-equiv^="Content"]' => '//meta[starts-with(@http-equiv, \'Content\')]',
            'meta[http-equiv^=Content]'   => '//meta[starts-with(@http-equiv, \'Content\')]',
            '[href$=\'html\']'            => '//*[@href and substring(@href, string-length(@href)-3) = \'html\']',
            '[href~=\'html\']'            => '//*[contains(concat(\' \', normalize-space(@href), \' \'), \' html \')]',
            '[href|=\'html\']'            => '//*[@href=\'html\' or starts-with(@href, \'html-\')]',
            '> a'                         => '/a',
            'p > a'                       => '//p/a',
            'p> a'                        => '//p/a',
            'p>a'                         => '//p/a',
            'p > a[href]'                 => '//p/a[@href]',
            'p a[href]'                   => '//p//a[@href]',
            ':disabled'                   => '//*[@disabled]',
            'div :header'                 => '//div//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6]',
            ':odd'                        => '//*[position() mod 2 = 0]',
            '.h'                          => '//*[contains(concat(\' \', normalize-space(@class), \' \'), \' h \')]',
            '.😾-_😾'                     => '//*[contains(concat(\' \', normalize-space(@class), \' \'), \' 😾-_😾 \')]',
            '.hidden'                     => '//*[contains(concat(\' \', normalize-space(@class), \' \'), \' hidden \')]',
            '.hidden-something'           => '//*[contains(concat(\' \', normalize-space(@class), \' \'), \' hidden-something \')]',
            'a.hidden[href]'              => '//a[contains(concat(\' \', normalize-space(@class), \' \'), \' hidden \')][@href]',
            'a[href] > .hidden'           => '//a[@href]/*[contains(concat(\' \', normalize-space(@class), \' \'), \' hidden \')]',
            'a:not(b[co-ol])'             => '//a[not(self::b[@co-ol])]',
            'a:not(b,c)'                  => '//a[not(self::b or self::c)]',
            'a:not(.cool)'                => '//a[not(self::*[contains(concat(\' \', normalize-space(@class), \' \'), \' cool \')])]',
            'a:contains(txt)'             => '//a[text()[contains(.,\'txt\')]]',
            'h1 ~ ul'                     => '//h1/following-sibling::ul',
            'h1 + ul'                     => '//h1/following-sibling::ul[preceding-sibling::*[1][self::h1]]',
            'h1 ~ #id'                    => '//h1/following-sibling::*[@id=\'id\']',
            'p > a:has(> a)'              => '//p/a[child::a]',
            'p > a:has(>a)'               => '//p/a[child::a]',
            'p > a:has(b > a)'            => '//p/a[descendant::b/a]',
            'p > a:has(b> a)'             => '//p/a[descendant::b/a]',
            'p > a:has(b>a)'              => '//p/a[descendant::b/a]',
            'p>a:has(b>a)'                => '//p/a[descendant::b/a]',
            'p > a:has(a)'                => '//p/a[descendant::a]',
            'a:has(b)'                    => '//a[descendant::b]',
            'a:first-child:first'         => '//a[not(preceding-sibling::*)][1]',
            'div > a:first'               => '//div/a[1]',
            ':first'                      => '//*[1]',
            'img:nth-child(0)'            => '//img',
            'img:nth-child(234)'          => '//img[234]',
            'img:nth-child(-3)'           => '//img[last()-2]',
            ':gt(2)'                      => '//*[count(preceding-sibling::*)>=2]',
            ':lt(8)'                      => '//*[count(preceding-sibling::*)<=8]',
            'p:gt(2)'                     => '//p[count(preceding-sibling::*)>=2]',
            'p:lt(8)'                     => '//p[count(preceding-sibling::*)<=8]',
            'div p:gt(2)'                 => '//div//p[count(preceding-sibling::*)>=2]',
            'div p:lt(8)'                 => '//div//p[count(preceding-sibling::*)<=8]',
        );

        foreach ($css_to_xpath as $css => $expected_xpath) {
            $this->assertEquals($expected_xpath, CssToXpath::transform($css), $css);
        }
    }


    /*
     * Test invalid xpath expression
     */
    public function testInvalidPseudoSelector()
    {
        $this->expectException(\Exception::class);
        CssToXpath::transform('a:not-a-selector');
    }
}