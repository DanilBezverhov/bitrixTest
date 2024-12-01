<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

$host = 'http://localhost:4444/wd/hub';
$capabilities = DesiredCapabilities::chrome();
$options = new ChromeOptions();
$options->addArguments(["--headless", "--disable-gpu", "--window-size=1920x1080"]);
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($host, $capabilities);

try {
    $driver->get('https://lenta.ru/search?query=McDonalds');
    $wait = new WebDriverWait($driver, 10);
    $wait->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.search-results__list')));

    $newsItems = $driver->findElements(WebDriverBy::cssSelector('.search-results__item._news'));

    $newsData = [];
    foreach ($newsItems as $newsItem) {
        $title = $newsItem->findElement(WebDriverBy::cssSelector('.card-full-news__title'))->getText();
        $link = $newsItem->findElement(WebDriverBy::cssSelector('a'))->getAttribute('href');
        $newsData[] = [
            'title' => $title,
            'link' => $link,
        ];
    }

    $driver->quit();

    foreach ($newsData as $index => $news) {
        echo '
        <div class="col-lg-4 col-sm-6 mb-4">
            <div class="portfolio-item">
                <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal' . ($index + 1) . '">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                    </div>
                    <img class="img-fluid" src="assets/img/portfolio/' . (($index % 6) + 1) . '.jpg" alt="..." />
                </a>
                <div class="portfolio-caption">
                    <div class="portfolio-caption-heading">
                        <a href="' . htmlspecialchars($news['link']) . '" target="_blank" class="text-decoration-none">
                            ' . htmlspecialchars($news['title']) . '
                        </a>
                    </div>
                    <div class="portfolio-caption-subheading text-muted">Новости</div>
                </div>
            </div>
        </div>
        ';
    }
} catch (Exception $e) {
    $driver->quit();
    echo '<p class="text-muted">Ошибка: ' . $e->getMessage() . '</p>';
}
