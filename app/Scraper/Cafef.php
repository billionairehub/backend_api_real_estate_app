<?php

namespace App\Scraper;

use Goutte\Client;
use App\news_crawler;
use App\category_crawler;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;use Symfony\Component\HttpClient\HttpClient;

class Cafef
{

    public function scrape()
    {
        $client = new Client(HttpClient::create(['timeout' => 60*60*24]));
        $crawler = $client->request('GET', 'https://cafef.vn/bat-dong-san.chn');
        $crawler->filter('h3 > a')->each(function ($node) use($client){
            $link_href = $node->attr('href');
            $link ='https://cafef.vn'.$link_href;
            $crawler_deatil = $client->request('GET', $link);
            $description_cn = $crawler_deatil->filterXpath('//meta[@name="description"]')->attr('content');
            $keywords = $crawler_deatil->filterXpath('//meta[@name="keywords"]')->attr('content');
            $crawler_deatil->filter('.left_cate')->each(function ($node) use($description_cn, $keywords)
            {
                        $title = $node->filter('h1')->text();
                        $img = $node->filter('.media > img')->attr('src'); 
                        $date = $node->filter('.dateandcat > .pdate')->text(); 
                        $category = $node->filter('.dateandcat > a')->text(); 
                        $body_content = $node->filter('h2')->text();
                        $body = $node->filter('#mainContent')->text();
                        $author_post = $node->filter('.author')->text();
                        $source = $node->filter('.source')->text();
                        $all_category = category_crawler::where('category_name',$category)->first();
                        if($all_category == null){
                            $new_category = new category_crawler;
                            $new_category->category_name = $category;
                            $new_category->save();
                        }
                        $id_category = category_crawler::where('category_name',$category)->first();
                        $all_new = news_crawler::where('title',$title)->where('category_id',$id_category->id)->first();
                        if(!$all_new)
                        {
                            $news_hot = new news_crawler;
                            $news_hot->title = $title;
                            $news_hot->category_id = $id_category->id;
                            $news_hot->short_content = $body_content;
                            $news_hot->content = $body;
                            $news_hot->url_img = $img;
                            $news_hot->post_date = $date;
                            $news_hot->title_website = $title;
                            $news_hot->description = $description_cn;
                            $news_hot->keyword = $keywords;
                            $news_hot->sort = $title;
                            $news_hot->active = 1;
                            $news_hot->post_author = $author_post;
                            $news_hot->post_source = $source;
                            $news_hot->post_author_update = $author_post;
                            $news_hot->post_author_delete = $author_post;
                            $news_hot->save();
                            printf('Insert News sucess!');
                        }
                        else 
                        {
                            printf('News exits');
                        }
            });  
            $title_news = $crawler_deatil->filter('.left_cate  h1')->text();
            $crawler_deatil->filter('.newstcmtop')->each(function ($node) use($description_cn, $keywords, $client, $title_news)
            {
                        $title = $node->filter('h4')->text();
                        $link_news = $node->filter('h4 > a')->attr('href');
                        $full_link_news = 'https://cafef.vn'.$link_news;
                        $crawler_deatil_relate = $client->request('GET',$full_link_news);
                        $crawler_deatil_relate->filter('.left_cate')->each(function ($node) use($description_cn, $keywords, $title_news)
                        {
                                $title = $node->filter('h1')->text();
                                $img = $node->filter('.media > img')->attr('src'); 
                                $date = $node->filter('.dateandcat > .pdate')->text(); 
                                $category = $node->filter('.dateandcat > a')->text(); 
                                $body_content = $node->filter('h2')->text();
                                $body = $node->filter('#mainContent')->text();
                                $author_post = $node->filter('.author')->text();
                                $source = $node->filter('.source')->text();
                                $all_category = category_crawler::where('category_name',$category)->first();
                            if($all_category == null)
                            {
                                $new_category = new category_crawler;
                                $new_category->category_name = $category;
                                $new_category->save();
                            }
                                $id_category = category_crawler::where('category_name',$category)->first();
                                $all_new = news_crawler::where('title',$title)->where('category_id',$id_category->id)->first();
                            if(!$all_new)
                            {
                                $news_hot = new news_crawler;
                                $news_hot->title = $title;
                                $news_hot->category_id = $id_category->id;
                                $news_hot->short_content = $body_content;
                                $news_hot->content = $body;
                                $news_hot->url_img = $img;
                                $news_hot->post_date = $date;
                                $news_hot->title_website = $title;
                                $news_hot->description = $description_cn;
                                $news_hot->keyword = $keywords;
                                $news_hot->sort = $title;
                                $news_hot->active = 1;
                                $news_hot->post_author = $author_post;
                                $news_hot->post_source = $source;
                                $news_hot->post_author_update = $author_post;
                                $news_hot->post_author_delete = $author_post;
                                $news_hot->save();
                                printf('Insert news relate sucess!');
                            }
                            else 
                            {
                                printf('News exxits');
                            }
                        });    
            });
        });
    }
}