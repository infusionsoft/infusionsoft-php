<?php

namespace Infusionsoft;

enum AuthenticationType {
    case OAuth2AccessToken;
    case LegacyKey;
    case ServiceAccountKey;
}
