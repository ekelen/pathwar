package pwagent

import (
	"context"
	"time"

	"github.com/docker/docker/client"
	"go.uber.org/zap"
	"pathwar.land/v2/go/pkg/errcode"
	"pathwar.land/v2/go/pkg/pwapi"
	"pathwar.land/v2/go/pkg/pwcompose"
)

func Daemon(ctx context.Context, cli *client.Client, apiClient *pwapi.HTTPClient, opts Opts) error {
	started := time.Now()

	err := opts.applyDefaults()
	if err != nil {
		return errcode.TODO.Wrap(err)
	}

	logger := opts.Logger

	// FIXME: call API register in gRPC
	// ret, err := api.AgentRegister(ctx, &pwapi.AgentRegister_Input{Name: "dev", Hostname: "localhost", OS: "lorem ipsum", Arch: "x86_64", Version: "dev", Tags: []string{"dev"}})

	if opts.Cleanup {
		before := time.Now()
		err := pwcompose.DownAll(ctx, cli, logger)
		if err != nil {
			return errcode.ErrCleanPathwarInstances.Wrap(err)
		}
		logger.Info("docker cleaned up", zap.Duration("duration", time.Since(before)))
	}

	iteration := 0
	for {
		if !opts.RunOnce {
			logger.Debug("daemon iteration", zap.Int("number", iteration), zap.Duration("uptime", time.Since(started)))
		}

		err := runOnce(ctx, cli, apiClient, opts)
		if err != nil {
			logger.Error("daemon iteration", zap.Error(err))
		}

		if opts.RunOnce {
			break
		}

		opts.ForceRecreate = false // only do it once
		opts.Cleanup = false       // only do it once

		time.Sleep(opts.LoopDelay)
	}
	return nil
}

func runOnce(ctx context.Context, cli *client.Client, apiClient *pwapi.HTTPClient, opts Opts) error {
	instances, err := apiClient.AgentListInstances(&pwapi.AgentListInstances_Input{AgentName: opts.Name})
	if err != nil {
		return errcode.TODO.Wrap(err)
	}

	if err := applyDockerConfig(ctx, &instances, cli, opts); err != nil {
		return errcode.TODO.Wrap(err)
	}

	if err := applyNginxConfig(ctx, &instances, cli, opts); err != nil {
		return errcode.TODO.Wrap(err)
	}

	if err := updateAPIState(ctx, &instances, cli, apiClient, opts); err != nil {
		return errcode.TODO.Wrap(err)
	}

	return nil
}