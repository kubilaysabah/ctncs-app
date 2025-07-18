<?php

namespace App\Controller;

class HygraphClient
{
    private string | null $url = null;
    private string | null $token = null;

    public function __construct()
    {
        $this->url = $_ENV['HYGRAPH_API_URL'] ?? null;
        $this->token = $_ENV['HYGRAPH_API_KEY'] ?? null;
    }

    /**
     * GraphQL sorgusu gönder
     */
    public function query(string $query, array $variables = []): array
    {
        try {
            $headers = [
                'Content-Type: application/json',
            ];

            // Eğer auth token varsa header'a ekle
            if ($this->token) {
                $headers[] = 'Authorization: Bearer ' . $this->token;
            }

            $body = [
                'query' => $query,
            ];

            if (!empty($variables)) {
                $body['variables'] = $variables;
            }

            // cURL kullanarak istek gönder
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Development için

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new \Exception('cURL Error: ' . $error);
            }

            if ($httpCode !== 200) {
                throw new \Exception('HTTP Error: ' . $httpCode);
            }

            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON Decode Error: ' . json_last_error_msg());
            }

            if (isset($data['errors'])) {
                throw new \Exception('GraphQL Errors: ' . json_encode($data['errors']));
            }

            return $data['data'] ?? [];

        } catch (\Exception $e) {
            // Development için hata detayını logla
            error_log('HygraphClient Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Mutation gönder
     */
    public function mutate(string $mutation, array $variables = []): array
    {
        return $this->query($mutation, $variables);
    }

    public function getSettings(): array
    {
        $query = '
            query GetSettings {
              settings {
                id
                email {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                phone {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                facebook {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                whatsapp {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                instagram {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                twitter {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                youtube {
                  id
                  label
                  url
                  icon {
                    id
                    url
                    width
                    height
                  }
                }
                logo {
                  url
                  width
                  height
                }
              }
            }
        ';

        return $this->query($query)->settings ?? [];
    }

    public function getSlides(): array
    {
        $query = '
            query GetSlides {
              slides {
                    id
                    title
                    description
                    url
                    buttonText
                    mobileBanner {
                      id
                      url
                      width
                      height
                    }
                    desktopBanner {
                      id
                      url
                      width
                      height
                    }
              }
            }
        ';

        return $this->query($query);
    }
}
