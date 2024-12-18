<?php
// src/EventListener/RedirectListener.php
namespace Respinar\ContaoRedirectBundle\EventListener;

use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::REQUEST, priority: 1000)]
final class RedirectListener
{
    private Connection $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $uri = $request->getPathInfo();

        try {
            // Try exact match first
            $redirect = $this->db->fetchAssociative(
                'SELECT target_url, status_code FROM tl_redirect WHERE source_url = ? AND active = ?',
                [$uri, '1']
            );

            // If no exact match, try adding / to the stored source_url
            if (!is_array($redirect)) {
                $redirect = $this->db->fetchAssociative(
                    'SELECT target_url, status_code FROM tl_redirect WHERE CONCAT("/", source_url) = ? AND active = ?',
                    [$uri, '1']
                );
            }

            if (is_array($redirect)) {
                $statusCode = (int) ($redirect['status_code'] ?? 301);

                if ($statusCode === 410) {
                    // Return 410 Gone without redirecting
                    $response = new Response('This resource is permanently gone.', 410);
                    $event->setResponse($response);
                } elseif (in_array($statusCode, [301, 302])) {
                    // Handle redirects for 301/302 only
                    $targetUrl = $redirect['target_url'];
                    if (!str_starts_with($targetUrl, '/')) {
                        $targetUrl = '/' . $targetUrl;
                    }
                    $response = new RedirectResponse($targetUrl, $statusCode);
                    $event->setResponse($response);
                }
                // Ignore other status codes for now
            }
        } catch (\Exception $e) {
            // Optionally log: $this->logger->error(...) if logger is added
        }
    }
}